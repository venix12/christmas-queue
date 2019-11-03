import React, { Component } from 'react';

class Modal extends Component {
    render() {
        const { bgImg, children, desc, onClose, title } = this.props;
        return(
            <React.Fragment>
                <div className="modal__backdrop" onClick={onClose} />
                <div className="modal-card">
                    <div className="modal-card-header" style={{ backgroundImage: `url(${bgImg})` }}>
                        <div class="beatmap-badge round-text text-left">
                            {title} <br />
                            <small>{desc}</small>
                        </div>
                        <button className="button-circle fa fa-times bg-dark" onClick={onClose} />
                    </div>
                    <div className="modal-card-content">
                        {children}
                    </div>
                </div>
            </React.Fragment>
        )
    }
}

export default Modal;