CREATE TABLE IF NOT EXISTS users(
    id INTEGER PRIMARY KEY,
    full_name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    email_verified BOOLEAN NOT NULL DEFAULT 0,
    email_verification_token VARCHAR(255),
    email_verification_token_expires_at datetime,
    password_reset_token VARCHAR(255),
    password_reset_token_expires_at datetime,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT  'student' COLLATE NOCASE,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS courses(
    id INTEGER PRIMARY KEY,
    course_name TEXT UNIQUE NOT NULL,
    price INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS registered_courses(
    course_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    last_payment_id INTEGER NOT NULL,
    subscription_code TEXT NOT NULL,
    status TEXT NOT NULL DEFAULT 'active',
    FOREIGN KEY(course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES  users(id) ON DELETE CASCADE,
    FOREIGN KEY(last_payment_id) REFERENCES payments(id) ON DELETE RESTRICT
    PRIMARY KEY(user_id, course_id)
);

CREATE TABLE IF NOT EXISTS payments{
    id INTEGER PRIMARY KEY,
    user_id INTEGER  NOT NULL,
    course_id INTEGER NOT NULL,
    payment_reference TEXT NOT NULL,
    amount INTEGER NOT NULL,
    expiry_date DATETIME NOT NULL,
    payment_date datetime NOT NULL,
    FOREIGN KEY(course_id) REFERENCES courses(id) ON DELETE SET NULL,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE;
}

CREATE INDEX IF NOT EXISTS idx_users_email on users(email);
CREATE INDEX IF NOT EXISTS idx_reg_course_id on registered_courses(course_id);
CREATE INDEX IF NOT EXISTS idx_reg_user_id on registered_courses(user_id);
CREATE INDEX IF NOT EXISTS idx_reg_payment_id on registered_courses(last_payment_id);
CREATE INDEX IF NOT EXISTS idx_payments_user_id on payments(user_id);
CREATE INDEX IF NOT EXISTS idx_payments_course_id on payments(course_id);
