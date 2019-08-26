import axios from 'axios';

export const HTTP = axios.create({
    baseURL: 'https://localhost:8000/api',
    withCredentials: false,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});
