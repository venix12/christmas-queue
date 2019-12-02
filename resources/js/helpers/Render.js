import React from 'react';
import ReactDOM from 'react-dom';

export const render = (name, tag, props) => {
    if (document.getElementById(`react--${name}`) && props != null) {
        const el = document.getElementById(`react--${name}`);
        ReactDOM.render(React.createElement(tag, props), el);
    }
}
