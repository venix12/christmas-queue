import React, { Component } from 'react';

class UserCard extends Component {
    render() {
        return (
            <div class="user-card round-text text-left">
                <img class="avatar float-left" src={`https://a.ppy.sh/${this.props.osu_id}`}></img>
                {this.props.username}<br></br>
                <span class={`color-${this.props.user_title}`}>{this.props.user_title}</span>
            </div>
        );
    }
}

export default UserCard;