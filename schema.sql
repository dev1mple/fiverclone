CREATE TABLE fiverr_clone_users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    password TEXT,
    is_client BOOLEAN,
    user_role ENUM('client', 'freelancer', 'fiverr_administrator') DEFAULT 'client',
    bio_description TEXT,
    display_picture TEXT,
    contact_number VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL,
    description TEXT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE subcategories (
    subcategory_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    subcategory_name VARCHAR(255) NOT NULL,
    description TEXT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
);

CREATE TABLE proposals (
    proposal_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    description TEXT,
    image TEXT,
    min_price INT,
    max_price INT,
    category_id INT,
    subcategory_id INT,
    view_count INT DEFAULT 0,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES fiverr_clone_users(user_id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id),
    FOREIGN KEY (subcategory_id) REFERENCES subcategories(subcategory_id)
);

CREATE TABLE offers (
    offer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    description TEXT,
    proposal_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES fiverr_clone_users(user_id),
    FOREIGN KEY (proposal_id) REFERENCES proposals(proposal_id)
);

-- Insert sample categories
INSERT INTO categories (category_name, description) VALUES 
('Technology', 'Software development, programming, and tech services'),
('Design', 'Graphic design, UI/UX, and creative services'),
('Writing', 'Content writing, copywriting, and translation services'),
('Marketing', 'Digital marketing, SEO, and advertising services'),
('Business', 'Consulting, virtual assistance, and business services');

-- Insert sample subcategories
INSERT INTO subcategories (category_id, subcategory_name, description) VALUES 
-- Technology subcategories
(1, 'Web Development', 'Frontend, backend, and full-stack web development'),
(1, 'Mobile Development', 'iOS, Android, and cross-platform mobile apps'),
(1, 'Desktop Applications', 'Windows, Mac, and Linux desktop software'),
(1, 'Database Design', 'Database architecture and optimization'),
(1, 'DevOps & Cloud', 'Server management, deployment, and cloud services'),

-- Design subcategories
(2, 'Graphic Design', 'Logos, branding, and visual identity'),
(2, 'UI/UX Design', 'User interface and user experience design'),
(2, 'Web Design', 'Website layouts and responsive design'),
(2, 'Print Design', 'Business cards, flyers, and print materials'),
(2, 'Illustration', 'Digital art, drawings, and illustrations'),

-- Writing subcategories
(3, 'Content Writing', 'Blog posts, articles, and web content'),
(3, 'Copywriting', 'Sales copy, advertisements, and marketing content'),
(3, 'Technical Writing', 'Documentation, manuals, and technical content'),
(3, 'Translation', 'Language translation and localization'),
(3, 'Editing & Proofreading', 'Content editing and proofreading services'),

-- Marketing subcategories
(4, 'Social Media Marketing', 'Social media management and advertising'),
(4, 'SEO Services', 'Search engine optimization and ranking'),
(4, 'Email Marketing', 'Email campaigns and automation'),
(4, 'PPC Advertising', 'Pay-per-click and paid advertising'),
(4, 'Content Marketing', 'Content strategy and creation'),

-- Business subcategories
(5, 'Virtual Assistant', 'Administrative and support services'),
(5, 'Business Consulting', 'Strategy, planning, and business advice'),
(5, 'Data Entry', 'Data processing and entry services'),
(5, 'Customer Service', 'Support and customer relationship management'),
(5, 'Project Management', 'Project planning and coordination');