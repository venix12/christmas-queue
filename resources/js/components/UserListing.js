import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import UserCard from './UserCard';
import { render } from '../helpers/Render';

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

render('user-listing', UserListing, {data: globals.json('user-data')});
