// create db and table users, better-sqlite3
// run: node create_db.js
//
const sqlite3 = require('better-sqlite3');
const db = sqlite3('users.db');

const sql1 = `
DROP TABLE IF EXISTS users 
`; // DELETE USERS TABLE IF EXISTS
db.exec(sql1);
const sql = `
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        tk TEXT NOT NULL,
        phone TEXT NOT NULL,
        card_type TEXT NOT NULL,
        card_number TEXT NOT NULL,
        address TEXT NOT NULL,
        country TEXT NOT NULL
    )
`;
db.exec(sql);
console.log('Database and table users created successfully!');
