import React from 'react';
import Layout from "./Layout";
import Homepage from "./Homepage";

function App(props) {
    React.useEffect(() => {
        console.log('init app');
    }, []);

    return (
        <Layout>
            <Homepage />
        </Layout>
    )
}

export default App;
