/**
 * k6 Load Test - GraphQL Skenario 1: Simple Query
 * Mengambil data donasi saja (1 tabel, tanpa relasi)
 * Setara dengan REST GET /api/research/simple
 *
 * Cara jalankan:
 *   k6 run k6/graphql-simple.js
 */

import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
    iterations: 15,
    vus: 1,
};

const BASE_URL = 'http://localhost:8000';

// Field yang diambil SAMA persis dengan REST simple
const QUERY = JSON.stringify({
    query: `{
        donasiSimple {
            id
            donatur
            jenis
            detail
            jumlah
            tanggal
            status
            status_verifikasi
            petugas
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
