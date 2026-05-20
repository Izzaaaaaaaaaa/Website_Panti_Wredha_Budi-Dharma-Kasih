/**
 * k6 Load Test - REST API Skenario 1: Simple Query
 * Mengambil data donasi saja (tanpa relasi)
 *
 * Cara jalankan:
 *   k6 run k6/rest-simple.js
 */

import http from 'k6/http';
import { check, sleep } from 'k6';

// Konfigurasi: 15 iterasi, 1 virtual user
export const options = {
    iterations: 15,
    vus: 1,
};

const BASE_URL = 'http://localhost:8000';

export default function () {
    const res = http.get(`${BASE_URL}/api/research/simple`, {
        headers: { 'Accept': 'application/json' },
    });

    check(res, {
        'status 200': (r) => r.status === 200,
        'response time < 2000ms': (r) => r.timings.duration < 2000,
    });

    sleep(0.1);
}
