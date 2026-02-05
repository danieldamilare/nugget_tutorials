CREATE TABLE IF NOT EXISTS users(
    id INTEGER PRIMARY KEY,
    full_name TEXT NOT NULL,
    bio TEXT,
    email TEXT UNIQUE NOT NULL,
    profile_image_url TEXT,
    email_verified BOOLEAN NOT NULL DEFAULT 0,
    email_verification_token VARCHAR(255),
    email_verification_token_expires_at datetime,
    password_reset_token VARCHAR(255),
    password_reset_token_expires_at datetime,
    password_hash VARCHAR(255) NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT 1 ,
    role VARCHAR(50) NOT NULL DEFAULT  'student' COLLATE NOCASE CHECK (role IN ('student', 'instructor', 'admin')),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
);

CREATE TABLE IF NOT EXISTS courses(
    id INTEGER PRIMARY KEY,
    course_name TEXT UNIQUE NOT NULL,
    description TEXT,
    price INTEGER NOT NULL,
    category TEXT,
    duration INTEGER NOT NULL -- time block in hours
);

CREATE TABLE IF NOT EXISTS registered_courses(
    course_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    last_payment_id INTEGER NOT NULL,
    subscription_code TEXT NOT NULL,
    enrolled_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME,
    FOREIGN KEY(course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES  users(id) ON DELETE CASCADE,
    FOREIGN KEY(last_payment_id) REFERENCES payments(id) ON DELETE RESTRICT,
    PRIMARY KEY(user_id, course_id)
);

CREATE TABLE IF NOT EXISTS course_schedules(
    id INTEGER PRIMARY KEY,
    course_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    instructor_id INTEGER NOT NULL,
    status TEXT NOT NULL DEFAULT 'scheduled'
        CHECK (status IN ('scheduled', 'in_progress', 'completed', 'cancelled', 'no_show')),
    start_time datetime NOT NULL,
    end_time datetime NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS payments(
    id INTEGER PRIMARY KEY,
    user_id INTEGER NOT NULL,
    course_id INTEGER,
    payment_reference TEXT UNIQUE NOT NULL,
    amount INTEGER NOT NULL,
    payment_method TEXT,
    expiry_date DATETIME NOT NULL,
    payment_date datetime NOT NULL,
    FOREIGN KEY(course_id) REFERENCES courses(id) ON DELETE SET NULL,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS instructor_courses(
    user_id INTEGER NOT NULL,
    course_id INTEGER NOT NULL,
    FOREIGN KEY(course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
    PRIMARY KEY(user_id, course_id)
);

CREATE INDEX IF NOT EXISTS idx_users_email on users(email);
CREATE INDEX IF NOT EXISTS idx_reg_course_id on registered_courses(course_id);
CREATE INDEX IF NOT EXISTS idx_reg_user_id on registered_courses(user_id);
CREATE INDEX IF NOT EXISTS idx_reg_payment_id on registered_courses(last_payment_id);
CREATE INDEX IF NOT EXISTS idx_payments_user_id on payments(user_id);
CREATE INDEX IF NOT EXISTS idx_payments_course_id on payments(course_id);
