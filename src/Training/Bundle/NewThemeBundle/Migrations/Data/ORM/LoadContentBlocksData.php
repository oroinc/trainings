<?php

namespace Training\Bundle\NewThemeBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Gaufrette\Adapter\Local;
use Gaufrette\Filesystem;
use Oro\Bundle\AttachmentBundle\Entity\File as AttachmentFile;
use Oro\Bundle\CMSBundle\Entity\ContentBlock;
use Oro\Bundle\CMSBundle\Entity\TextContentVariant;
use Oro\Bundle\DigitalAssetBundle\Entity\DigitalAsset;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\MigrationBundle\Fixture\VersionedFixtureInterface;
use Oro\Bundle\UserBundle\DataFixtures\UserUtilityTrait;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Bundle\UserBundle\Migrations\Data\ORM\LoadAdminUserData;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

/**
 * Create or update content block based on data specified in file
 */
class LoadContentBlocksData extends AbstractFixture implements
    DependentFixtureInterface,
    ContainerAwareInterface,
    VersionedFixtureInterface
{
    use ContainerAwareTrait;
    use UserUtilityTrait;

    protected string $blocksConfigPath = '@TrainingNewThemeBundle/Migrations/Data/ORM/data/content_blocks.yml';

    public function getDependencies()
    {
        return [
            LoadAdminUserData::class
        ];
    }

    public function getVersion()
    {
        return '1.0';
    }

    public function load(ObjectManager $manager)
    {
        $user = $this->getFirstUser($manager);

        $contentBlockRepository = $manager->getRepository(ContentBlock::class);
        $rows = Yaml::parse(file_get_contents($this->getFilePathsFromLocator($this->blocksConfigPath)));

        foreach ($rows as $blockName => $blockData) {
            $contentBlock = $contentBlockRepository->findOneBy(['alias' => $blockName]);
            if ($contentBlock) {
                $this->updateExistingBlock($contentBlock, $blockData, $manager);
                continue;
            }

            $this->createNewBlock($blockName, $blockData, $manager, $user);
        }

        $manager->flush();
    }

    private function updateExistingBlock(ContentBlock $contentBlock, array $blockData, ObjectManager $manager): void
    {
        $title = $contentBlock->getDefaultTitle();
        $title->setString($blockData['title']);

        $variants = $contentBlock->getContentVariants();
        foreach ($variants as $variant) {
            if (!$variant->isDefault()) {
                continue;
            }
            $variant->setContent($blockData['content']);
        }
        $manager->persist($contentBlock);
    }

    private function createNewBlock(string $blockName, array $blockData, ObjectManager $manager, User $user): void
    {
        $title = new LocalizedFallbackValue();
        $title->setString($blockData['title']);
        $manager->persist($title);

        $variant = new TextContentVariant();
        $variant->setDefault(true);
        $variant->setContent($blockData['content']);

        $manager->persist($variant);

        $contentBlock = new ContentBlock();
        $contentBlock->setOrganization($user->getOrganization());
        $contentBlock->setOwner($user->getOwner());
        $contentBlock->setAlias($blockName);
        $contentBlock->addTitle($title);
        $contentBlock->addContentVariant($variant);
        $manager->persist($contentBlock);
    }

    protected function getFilePathsFromLocator(string $path): array|string
    {
        $locator = $this->container->get('file_locator');
        return $locator->locate($path);
    }

    protected function createImage(
        ObjectManager $manager,
        User $user,
        string $fileRoot,
        string $filename,
        string $fileExtension
    ): AttachmentFile {
        $locator = $this->container->get('file_locator');

        $imagePath = $locator->locate(sprintf('%s/%s.%s', $fileRoot, $filename, $fileExtension));
        if (is_array($imagePath)) {
            $imagePath = current($imagePath);
        }

        $file = $this->container->get('oro_attachment.file_manager')->createFileEntity($imagePath);
        $file->setOwner($user);
        $manager->persist($file);

        $imageTitle = new LocalizedFallbackValue();
        $imageTitle->setString($filename);
        $manager->persist($imageTitle);

        $digitalAsset = new DigitalAsset();
        $digitalAsset->addTitle($imageTitle)
            ->setSourceFile($file)
            ->setOwner($user)
            ->setOrganization($user->getOrganization());
        $manager->persist($digitalAsset);

        $image = new AttachmentFile();
        $image->setDigitalAsset($digitalAsset);
        $manager->persist($image);
        $manager->flush();

        $this->writeDigitalAssets($file, $locator, $fileRoot, $filename, $fileExtension, 'original');

        return $image;
    }

    protected function writeDigitalAssets(
        AttachmentFile $file,
        FileLocator $locator,
        string $fileRoot,
        string $filename,
        string $fileExtension,
        string $filter
    ): void {
        $storagePath = $this->container->get('oro_attachment.provider.resized_image_path')
            ->getPathForFilteredImage($file, $filter);

        $rootPath = $locator->locate($fileRoot);
        if (is_array($rootPath)) {
            $rootPath = current($rootPath);
        }

        $filesystem = new Filesystem(new Local($rootPath, false, 0600));

        $file = $filesystem->get(sprintf('%s.%s', $filename, $fileExtension));

        $this->container->get('oro_attachment.manager.protected_mediacache')
            ->writeToStorage($file->getContent(), $storagePath);
    }
}
