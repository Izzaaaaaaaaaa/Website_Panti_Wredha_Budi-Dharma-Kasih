/**
 * k6 Load Test - GraphQL Skenario 3: Complex Query
 * Mengambil data donasi + user + laporan_donasi
 * Setara dengan REST GET /api/research/complex
 *
 * Cara jalankan:
 *   k6 run k6/graphql-complex.js
 */

import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
    iterations: 15,
    vus: 1,
};

const BASE_URL = 'http://localhost:8000';

// Query GraphQL - field yang diambil SAMA dengan REST complex
const QUERY = JSON.stringify({
    query: `{
        donasiComplex {
            id
            donatur
            jenis
            detail
            jumlah
            tanggal
            status
            petugas
            status_verifikasi
            catatan
            user {
                id
                nama
                email
                no_hp
                role
            }
            laporan {
                id
                donasi_id
                email_donatur
                isi_laporan
                status
                sent_at
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
