import React, { Component } from 'react';

class UserCard extends Component {
    render() {
        const { osu_id, username, user_title} = this.props;
        return (
            <div class="user-card round-text text-left">
                <img class="avatar float-left" src={`https://a.ppy.sh/${osu_id}`}></img>
                {username}<br></br>
                <span class={`color-${user_title.toLowerCase()}`}>{user_title}</span>
            </div>
        );
    }
}

export default UserCard;