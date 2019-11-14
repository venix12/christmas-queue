import React, { Component } from 'react';

class UserCard extends Component {
    render() {
        const { osu_id, username, user_title} = this.props;
        return (
            <a href={`https://osu.ppy.sh/u/${osu_id}`} class="user-card text-left">
                <img class="avatar float-left" src={`https://a.ppy.sh/${osu_id}`}></img>
                {username}<br></br>
                {user_title && <span class={`color-${user_title.toLowerCase()}`}>{user_title}</span>}
            </a>
        );
    }
}

export default UserCard;