/**
 * k6 Load Test - GraphQL Skenario 2: Medium Query
 * Mengambil data donasi + user (donatur)
 * Setara dengan REST GET /api/research/medium
 *
 * Cara jalankan:
 *   k6 run k6/graphql-medium.js
 */

import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
    iterations: 15,
    vus: 1,
};

const BASE_URL = 'http://localhost:8000';

// Query GraphQL - field yang diambil SAMA dengan REST medium
const QUERY = JSON.stringify({
    query: `{
        donasiMedium {
            id
            donatur
            jenis
            detail
            jumlah
            tanggal
            status
            status_verifikasi
            user {
                id
                nama
                email
                no_hp
                role
            }
        }
    }`,
});

export default function () {
    const res = http.post(`${BASE_URL}/graphql`, QUERY, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    });

    check(res, {
        'status 200': (r) => r.status === 200,
        'no errors': (r) => !JSON.parse(r.body).errors,
        'response time < 2000ms': (r) => r.timings.duration < 2000,
    });

    sleep(0.1);
}
