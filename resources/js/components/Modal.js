import React, { Component } from 'react';

class Modal extends Component {
    render() {
        const { bgImg, children, desc, link, onClose, title } = this.props;
        return(
            <React.Fragment>
                <div className="modal__backdrop" onClick={onClose} />
                <div className="modal__card">
                    <div className="modal__card__header" style={{ backgroundImage: `url(${bgImg})` }}>
                        <a class="beatmap-card__badge round-text text-left" href={link}>
                            {title} <br />
                            <small>{desc}</small>
                        </a>
                        <button className="button button--circle fa fa-times bg-dark" onClick={onClose} />
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