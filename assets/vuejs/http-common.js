import axios from 'axios';

export const HTTP = axios.create({
    baseURL: 'api',
    withCredentials: false,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

