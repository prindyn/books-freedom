import axios from 'axios';

export default class Auth {
    constructor() {
        this.token = window.localStorage.getItem('token');
        let userData = window.localStorage.getItem('user');
        if (this.token == 'undefined') {
            window.localStorage.removeItem('token');
        }
        if (this.userData == 'undefined') {
            window.localStorage.removeItem('user');
        }
        this.user = userData ? JSON.parse(userData) : null;

        if (this.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        }
    }

    login(token, user) {
        window.localStorage.setItem('token', token);
        window.localStorage.setItem('user', JSON.stringify(user));

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

        this.token = token;
        this.user = user;
    }

    check() {
        return !!this.token;
    }

    logout() {
        window.localStorage.removeItem('user');
        window.localStorage.removeItem('token');

        this.user = null;
        this.token = null;
    }
}