import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { adminPages, pages } from './Routes';

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
                                <a class="nav__el nav__badge" href={page.href}>
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

if (document.getElementById('navbar')) {
    const currentPage = document.getElementById('navbar').getAttribute('current');
    ReactDOM.render(<Navbar admin="false" currentPage={currentPage} />, document.getElementById('navbar'));
}

if (document.getElementById('navbar-admin')) {
    const currentPage = document.getElementById('navbar-admin').getAttribute('current');
    ReactDOM.render(<Navbar admin currentPage={currentPage} />, document.getElementById('navbar-admin'));
}