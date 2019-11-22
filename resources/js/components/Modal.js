import React, { Component } from 'react';

class Modal extends Component {
    render() {
        const { bgImg, children, header, onClose} = this.props;
        return(
            <React.Fragment>
                <div className="modal__backdrop" onClick={onClose} />
                <div className="modal__card">
                    <div className="modal__card__header" style={bgImg ? { backgroundImage: `url(${bgImg})` } : { backgroundColor: 'black' }}>
                        {header}
                        <div className="close-button" onClick={onClose} />
                    </div>
                    <div className="modal__card__content">
                        {children}
                    </div>
                </div>
            </React.Fragment>
        )
    }
}

export default Modal;