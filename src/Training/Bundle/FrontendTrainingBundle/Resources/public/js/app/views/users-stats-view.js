import BaseView from 'oroui/js/app/views/base/view';
import template from 'tpl-loader!trainingfrontendtraining/templates/users-stats-template.html';

const UsersStatsView = BaseView.extend({

    userStats: [],

    /**
     * @inheritdoc
     */
    constructor: function UsersStatsView(options) {
        UsersStatsView.__super__.constructor.call(this, options);
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.userStats = options.userStats || this.userStats;
        UsersStatsView.__super__.initialize.call(this, options);
    },

    render: function() {
        this.$el.html(template({
            userStats: this.userStats
        }));
    },

    /**
     * @inheritdoc
     */
    dispose: function() {
        if (this.disposed) {
            return;
        }
        this.userStats = [];

        return UsersStatsView.__super__.dispose.call(this);
    }
});

export default UsersStatsView;
