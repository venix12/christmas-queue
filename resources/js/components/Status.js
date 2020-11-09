import React, { Component } from 'react';

class Status extends Component {
    render() {
        const { message, status } = this.props;

        return (
            <div className="status-container">
                <div className={`warning-badge warning-badge--${status}`}>
                    {message}
                </div>
            </div>
        );
    }
}

export default Status;
