/**
 * k6 Load Test - GraphQL Skenario 2: Medium Query
 * Mengambil data donasi + data donatur/user (2 tabel, 1 relasi)
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

// Field yang diambil SAMA persis dengan REST medium
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
            petugas
            user {
                id
                nama
                email
                no_hp
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
