import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { adminPages, pages } from './Routes';
import { render } from '../helpers/Render';

export default class Navbar extends Component {
    state = {
        admin: this.props.admin
    }

    nav = (routes) => {
        const { currentPage } = this.props;
        return(
            <div class="nav__bg">
                {routes.map((page, index) =>{
                    return(
                        <React.Fragment key={index}>
                            {page.title === currentPage ?
                                <a class="nav__el nav__el--current" href={page.href}>
                                    {page.title}
                                </a> : <a class="nav__el" href={page.href}>
                                    {page.title}
                                </a>}
                        </React.Fragment>
                    )
                })}
            </div>
        )
    }

    render() {
        const { admin } = this.state;
        return(
            <div>
                {admin === true ? this.nav(adminPages) : this.nav(pages)}
            </div>
        )
    }
}

render('navbar', Navbar, {
    admin: false,
    currentPage: globals.getElementAttribute('react--navbar', 'current')
});

render('navbar-admin', Navbar, {
    admin: true,
    currentPage: globals.getElementAttribute('react--navbar-admin', 'current')
});