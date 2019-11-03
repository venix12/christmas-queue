import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import UserCard from './UserCard';

const getUserTitle = (user) => {
    if(user.isAmbassador === true) {
        return 'Ambassador';
    } else if(user.isModder) {
        return 'Modder';
    }
}

export default class UserListing extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        const { data } = this.props;
        return (
            <div>
                {data.map(user => {
                    return <UserCard
                        key={user.id}
                        username={user.username}
                        osu_id={user.osu_id}
                        user_title={getUserTitle(user)}
                        >
                    </UserCard>
                })}
            </div>
        );
    }
}

if (document.getElementById('user-listing')) {
    const data = JSON.parse(document.getElementById('user-listing').getAttribute('data'));
    ReactDOM.render(<UserListing data={data} />, document.getElementById('user-listing'));
}
