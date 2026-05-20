/**
 * k6 Load Test - REST API Skenario 2: Medium Query
 * Mengambil data donasi + user (donatur)
 *
 * Cara jalankan:
 *   k6 run k6/rest-medium.js
 */

import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
    iterations: 15,
    vus: 1,
};

const BASE_URL = 'http://localhost:8000';

export default function () {
    const res = http.get(`${BASE_URL}/api/research/medium`, {
        headers: { 'Accept': 'application/json' },
    });

    check(res, {
        'status 200': (r) => r.status === 200,
        'response time < 2000ms': (r) => r.timings.duration < 2000,
    });

    sleep(0.1);
}
