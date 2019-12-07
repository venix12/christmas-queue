import React, { Component } from 'react';
import { UserCard } from './user-card';
import { render } from '../helpers/Render';
import UserPanel from './UserPanel';

const getUserTitle = (user) => {
    if(user.isAmbassador === true) {
        return 'Ambassador';
    } else if(user.isModder) {
        return 'Modder';
    }
}

export default class UserListing extends Component {
    state = {
        list: false
    }

    componentDidMount() {
        $('[title]').tooltip({
            animation: false,
            trigger: 'hover'
        });
    }

    cards = () => {
        const { data } = this.props;
        return (
            <div>
                {data.map(user => {
                    return <UserCard
                        key={user.id}
                        username={user.username}
                        osu_id={user.osu_id}
                        user_title={getUserTitle(user)}
                    />
                })}
            </div>
        );
    }

    list = () => {
        const { data } = this.props;
        return (
            <div>
                {data.map(user => {
                    return <UserPanel
                        admin="true"
                        key={user.id}
                        user={user}
                    />
                })}
            </div>
        );
    }

    switch = (list) => {
        this.setState({ list: list });
    }

    switcher = () => {
        const { list } = this.state;
        return (
            <div class="toggle">
                <i
                    className={`toggle__el ${!list && 'toggle__el--current'} fa fa-th-large`}
                    onClick={() => this.switch(false)}
                    title="Card view"
                />
                <i
                    className={`toggle__el ${list && 'toggle__el--current'} fa fa-bars`}
                    onClick={() => this.switch(true)}
                    title="List view"
                />
            </div>
        )
    }

    render() {
        const { list } = this.state;
        return(
            <div className="user-listing">
                {this.switcher()}
                {list ? this.list() : this.cards()}
            </div>
        )
    }

}

render('user-listing', UserListing, {data: globals.json('user-data')});
