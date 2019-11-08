import React, { Component } from 'react';
import ReactDOM from 'react-dom';


const pages = [
    {
        title: 'Home',
        href: '/christmas-queue/public'
    },
    {
        title: 'Users',
        href: 'users'
    },
    {
        title: 'Beatmaps',
        href: 'beatmaps'
    },
    {
        title: 'Manage',
        href: 'admin-beatmaps'
    }
];

export default class Navbar extends Component {
    render() {
        const { currentPage } = this.props;
        return(
            <div class="nav-bg">
                {pages.map((page, index) =>{
                    return(
                        <React.Fragment key={index}>
                            {page.title === currentPage ?
                                <a
                                class="nav-el nav-badge"
                                href={page.href}>
                                    {page.title}
                                </a> : <a
                                class="nav-el"
                                href={page.href}>
                                    {page.title}
                                </a>}
                        </React.Fragment>
                    )
                })}
            </div>
        )
    }
}

if (document.getElementById('navbar')) {
    const currentPage = document.getElementById('navbar').getAttribute('current');
    ReactDOM.render(<Navbar currentPage={currentPage} />, document.getElementById('navbar'));
}