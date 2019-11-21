import React, { Component } from 'react';

const getIcon = (state) => {
    let color, icon;
    switch(state) {
        case 'success':
            color = 'green';
            icon = 'check';
            break;
        case 'error':
            color = 'orange';
            icon = 'warning';
            break;
    }

    return [color, icon];
}

class Status extends Component {
    render() {
        const [color, icon] = getIcon(this.props.status)
        return (
            <div class="warning-badge">
                <i class={`fa fa-${icon} color--${color} v-middle`}></i> {this.props.message}
            </div>
        );
    }
}

export default Status;