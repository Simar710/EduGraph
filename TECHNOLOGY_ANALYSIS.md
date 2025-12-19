# EduGraph - Technology Stack & Architecture Analysis

## Project Overview

**EduGraph** is a comprehensive full-stack web application designed to help students navigate course prerequisites and plan their academic journey at the University of Guelph. The project evolved through 9 sprints, progressively adding features from basic CLI parsing to a fully deployed web application with CI/CD pipelines.

**Live URL:** http://34.201.123.35/ (Note: May be terminated based on AWS resource consumption)

---

## Core Purpose

EduGraph serves multiple educational purposes:

1. **Course Data Management** - Parse and process university course information including prerequisites and restrictions
2. **Course Eligibility Checking** - Help students determine which courses they're eligible to take based on completed coursework
3. **Course Recommendations** - Generate personalized course recommendations based on student progress
4. **Prerequisite Visualization** - Display course prerequisite relationships as interactive graphs and trees
5. **Course Information Search** - Provide REST APIs for querying course data by various criteria

---

## Technology Stack Breakdown

### 1. Backend Technologies

#### **PHP (Primary Backend Language)**
- **Purpose:** Server-side scripting for web application logic
- **Usage:**
  - REST API implementation for all course data endpoints
  - Dynamic HTML page generation
  - Database connection management
  - Request/response handling
- **Key Files:**
  - `db_connection.php` - Database connection utilities
  - `get_all_courses.php` - Fetch all courses
  - `get_course_by_code.php` - Search by course code
  - `get_course_by_name.php` - Search by course name with fuzzy matching
  - `get_courses_by_prereq.php` - Filter courses by prerequisites
  - `get_courses_by_restrict.php` - Filter courses by restrictions
  - `post_courses.php` - Add new courses (to copy table)
  - `put_dbInfo.php` - Update existing courses
  - `delete_course_by_code.php` - Delete courses
  - `generate_recommendations.php` - Generate course recommendations

#### **MySQL Database**
- **Purpose:** Persistent storage for course information
- **Usage:**
  - Database name: `cis3760`
  - Primary table: `coursesDB` - Contains all course data
  - Copy table: `coursesDBCopy` - Used for testing POST/PUT/DELETE operations
- **Schema:**
  ```sql
  CREATE TABLE coursesDB (
      courseCode VARCHAR(20),
      courseName VARCHAR(255),
      prerequisites TEXT,
      restrictions TEXT
  );
  ```
- **Data Loading:** CSV files parsed by Python scripts are loaded into MySQL using `LOAD DATA INFILE`

#### **Python (Data Processing)**
- **Purpose:** Command-line tools for parsing and searching course data
- **Usage:**
  
  **Parser (`parser/main.py`):**
  - Parses raw text files containing course information
  - Extracts course codes, names, prerequisites, and restrictions
  - Uses regular expressions for pattern matching
  - Handles complex prerequisite logic (OR/AND operators)
  - Outputs structured CSV files
  - Key regex patterns:
    - Course details: `r"([A-Z]{3,4}\*\d{4})\s+(.*?)\s+\[[\d.]+\]"`
    - Prerequisites: `r"Prerequisite\(s\):(.*?)(Restriction\(s\)|Location\(s\)|...)"`
  
  **Searcher (`searcher/search.py`):**
  - CLI menu-based interface for searching parsed courses
  - Search options:
    1. Course Name Search
    2. Subject Search (e.g., all CIS courses)
    3. Course Code Search (e.g., CIS*1300)
  - Displays course code, name, and prerequisites

### 2. Frontend Technologies

#### **HTML5**
- **Purpose:** Structure and content of web pages
- **Usage:**
  - Semantic HTML for accessibility
  - Form elements for user input
  - ARIA labels for screen reader support
  - Main pages:
    - `index.php` - Homepage with team information
    - `course_generator/index.php` - Course recommendation interface
    - `course_generator/genTree/index.php` - Prerequisite tree generator
    - Team member pages (sara, emily, maneesh, feekim, simardeep)

#### **CSS3**
- **Purpose:** Styling and visual presentation
- **Usage:**
  - Responsive design for multiple screen sizes
  - Dark mode theme support
  - Custom styling for buttons, forms, and navigation
  - Consistent color palette across pages
  - High-contrast theme for accessibility (WCAG 2.1 compliance)

#### **JavaScript (Client-Side)**
- **Purpose:** Interactive functionality and dynamic content
- **Usage:**
  - AJAX calls to REST APIs for fetching course data
  - Dark mode toggle with localStorage persistence
  - Dynamic course list management (add/remove courses)
  - Form validation and submission handling
  - Dropdown menu population
  - Interactive search functionality

#### **Bootstrap 5.3.2**
- **Purpose:** CSS framework for responsive design
- **Usage:**
  - Grid system for layout
  - Pre-built components (buttons, cards, forms)
  - Responsive navigation
  - Modal dialogs
  - Mobile-first approach

#### **jQuery 3.7.1**
- **Purpose:** Simplified DOM manipulation and AJAX
- **Usage:**
  - Event handling
  - AJAX requests to PHP APIs
  - DOM traversal and manipulation
  - Animation effects

#### **Vis.js Network Library**
- **Purpose:** Graph and tree visualization
- **Usage:**
  - Interactive prerequisite graphs showing course relationships
  - Hierarchical tree layouts for course dependencies
  - Node and edge customization
  - Physics simulation for graph layout
  - Click/hover interactions on nodes
  - Ability to download generated trees
- **Features:**
  - Display all courses in a subject as a prerequisite tree
  - Generate trees for all courses (resource-intensive, 2-5 minutes)
  - Search functionality to highlight specific courses
  - Interactive zoom and pan

### 3. Web Server & Infrastructure

#### **Nginx**
- **Purpose:** Web server and reverse proxy
- **Usage:**
  - Serves static files (HTML, CSS, JS, images)
  - Routes requests to PHP-FPM for PHP processing
  - URL rewriting for clean REST API endpoints
  - Handles FastCGI communication
  - Port configuration: 8082 (local), 80 (AWS)
- **Key Configuration:**
  - FastCGI pass to PHP-FPM (socket-based on AWS, TCP on local)
  - Location blocks for API routing
  - Try_files directives for fallback handling
  - Custom 404 error pages

#### **PHP-FPM (FastCGI Process Manager)**
- **Purpose:** PHP process manager for Nginx
- **Usage:**
  - Executes PHP scripts
  - Connection via Unix socket (AWS) or TCP (local: 127.0.0.1:9000)
  - Handles POST, PUT, DELETE HTTP methods
  - Process pool management

#### **AWS EC2 (Cloud Deployment)**
- **Purpose:** Cloud hosting platform
- **Usage:**
  - Ubuntu Server instance
  - Public IP: 34.201.123.35
  - Security groups for HTTP/HTTPS/SSH access
  - Production environment deployment
  - Remote server management via SSH

### 4. Development Tools & Utilities

#### **VBA (Visual Basic for Applications)**
- **Purpose:** Excel-based UI for course eligibility checking
- **Usage:**
  - Macro-enabled Excel workbook (`parsed_courses.xlsm`)
  - User inputs completed courses and credits
  - VBA scripts parse prerequisites and determine eligibility
  - Generates list of courses student can take next
  - Uses ActiveX RegEx component (Windows-only)
- **Location:** `VBASprint2/` directory

#### **Git & GitHub**
- **Purpose:** Version control and collaboration
- **Usage:**
  - Source code management
  - Branch-based development (sprint1-sprint9 branches)
  - Pull request workflow
  - Issue tracking

### 5. CI/CD & Testing

#### **GitHub Actions**
- **Purpose:** Continuous Integration/Deployment for GitHub
- **Configuration:** `.github/workflows/ci-cd.yml`
- **Workflow:**
  1. Triggered on push to `sprint9` branch
  2. Checkout code
  3. Set up SSH keys for EC2 access
  4. Deploy changes to AWS EC2 instance
  5. Copy HTML files to `/var/www/html/`
  6. Run automated tests using Selenium
- **Jobs:**
  - `deploy` - Deploys code to production
  - `test` - Runs Selenium test suite

#### **GitLab CI/CD**
- **Purpose:** Continuous Integration/Deployment for GitLab
- **Configuration:** `.gitlab-ci.yml`
- **Stages:**
  1. `deploy` - Pulls latest code, copies to web directory
  2. `test` - Runs Selenium tests in headless Chrome
- **Features:**
  - Detects changes in HTML folder
  - Conditional deployment based on branch
  - Commit message logging

#### **Selenium IDE**
- **Purpose:** Browser automation testing
- **Usage:**
  - Front-end automation testing
  - UI interaction testing
  - Regression testing
  - Test cases stored as `.side` files
- **Test Suites:**
  - `Sprint7.side` - General UI tests
  - `Tree_Generator.side` - Tree generation functionality tests
  - `All_course_Tree.side` - Comprehensive tree generation (2-5 minutes)
- **Execution:**
  - `selenium-side-runner` CLI tool
  - Headless Chrome browser
  - ChromeOptions: `--no-sandbox`, `--headless`, `--disable-gpu`, `--disable-dev-shm-usage`

### 6. Additional Libraries & Frameworks

#### **Font Awesome 5.15.4**
- **Purpose:** Icon library
- **Usage:**
  - Navigation icons (home button)
  - Dark mode toggle (moon/sun icons)
  - Social media icons
  - UI enhancement

#### **Google Fonts**
- **Purpose:** Custom typography
- **Fonts Used:**
  - Playfair Display - Headers
  - Lato - Body text
  - Merriweather - Accent text
- **Usage:** Improves readability and visual appeal

#### **Popper.js**
- **Purpose:** Tooltip and popover positioning
- **Usage:** Works with Bootstrap for dropdown menus and tooltips

---

## REST API Architecture

### API Base URL
- Production: `http://34.201.123.35/`
- API Pattern: `/courses/<functionality>/`
- **Important:** Trailing slash is required

### Endpoints Summary

| Method | Endpoint | Purpose |
|--------|----------|---------|
| GET | `/courses/getAllCourses/` | Retrieve all courses |
| GET | `/courses/getAllCoursesCopy/` | Retrieve courses from copy table |
| GET | `/courses/getSubjects/` | Get list of all subjects |
| POST | `/courses/getCoursesBySubject/` | Filter courses by subject(s) |
| POST | `/courses/getCourseByCode/` | Get course by code |
| POST | `/courses/getCourseByName/` | Fuzzy search by course name |
| POST | `/courses/getCoursesByPrereq/` | Filter by prerequisites (AND/OR logic) |
| POST | `/courses/getCoursesByRestrictions/` | Filter by restrictions (AND/OR logic) |
| POST | `/courses/postCourses/` | Add new course to copy table |
| PUT | `/courses/update/` | Update course information |
| DELETE | `/courses/delete/` | Delete course by code |

### API Features
- **JSON request/response format**
- **HTTP status codes:** 200 (success), 400 (bad request), 404 (not found), 405 (method not allowed), 500 (server error)
- **Fuzzy search** for course names
- **Logical operators** (AND/OR) for prerequisite and restriction filtering
- **Case-insensitive** course code matching
- **Error handling** with descriptive messages

---

## Data Flow Architecture

### 1. Data Ingestion Pipeline
```
Raw Text Files (f23_courses1.txt, f23_courses2.txt)
    ↓
Python Parser (main.py)
    ↓
CSV File (parsed_courses.csv)
    ↓
MySQL LOAD DATA INFILE
    ↓
MySQL Database (coursesDB table)
```

### 2. Web Application Flow
```
User Browser
    ↓
Nginx (Port 80/8082)
    ↓
PHP-FPM
    ↓
PHP Scripts (API Endpoints)
    ↓
MySQL Database
    ↓
JSON Response
    ↓
JavaScript (Client-side)
    ↓
Vis.js / DOM Updates
    ↓
User Interface
```

### 3. CI/CD Pipeline Flow
```
Developer Commit
    ↓
Git Push to sprint9 branch
    ↓
GitHub Actions / GitLab CI Trigger
    ↓
Code Checkout
    ↓
SSH to AWS EC2
    ↓
Copy files to /var/www/html/
    ↓
Restart Nginx
    ↓
Run Selenium Tests
    ↓
Report Results
```

---

## Key Features & Functionality

### 1. Course Recommendation System
- **Input:** List of completed courses
- **Process:** 
  - Queries API with completed courses using OR logic
  - Filters courses where prerequisites are met
  - Excludes already completed courses
- **Output:** Personalized list of eligible courses
- **UI:** Interactive form with add/remove course buttons

### 2. Prerequisite Tree Visualization
- **Input:** Subject code (e.g., CIS) or all courses
- **Process:**
  - Fetches all courses for subject via API
  - Parses prerequisite relationships
  - Creates nodes and edges for Vis.js
  - Applies hierarchical layout algorithm
- **Output:** Interactive graph showing course dependencies
- **Features:**
  - Search to highlight specific courses
  - Download tree as image
  - Zoom and pan controls
  - Click nodes for course details

### 3. Course Search & Filtering
- **Multiple search criteria:**
  - By course code (exact match)
  - By course name (fuzzy search)
  - By subject (all courses in subject)
  - By prerequisites (courses requiring specific prerequisites)
  - By restrictions (courses with specific restrictions)
- **Boolean logic:** AND/OR operators for complex queries
- **Empty query support:** Find courses with no prerequisites/restrictions

### 4. Dark Mode
- **Toggle switch:** Moon/sun icon in top corner
- **Persistence:** State stored in localStorage
- **Scope:** Applies across all pages
- **CSS variables:** Dynamic theme switching

### 5. Accessibility Features (WCAG 2.1 Compliant)
- **Keyboard navigation:**
  - Tab through all interactive elements
  - Enter key triggers buttons
  - Arrow keys for dropdown navigation
  - Escape key to close modals
- **ARIA labels:** Descriptive labels for screen readers
- **High contrast:** Dark mode for better visibility
- **Semantic HTML:** Proper heading hierarchy and landmarks
- **Focus indicators:** Clear visual focus states

---

## Development Environment Setup

### Local Setup (macOS/Linux)

#### Prerequisites
- Homebrew (macOS) or apt (Linux)
- MySQL
- PHP
- Nginx
- Python 3

#### Installation Steps
1. **Install MySQL:**
   ```bash
   brew install mysql
   brew services start mysql
   mysql -u root
   ```

2. **Install PHP:**
   ```bash
   brew install php
   brew services start php
   ```

3. **Install Nginx:**
   ```bash
   brew install nginx
   brew services start nginx
   ```

4. **Configure Nginx:**
   - Copy config to `/opt/homebrew/etc/nginx/nginx.conf` (ARM) or `/usr/local/etc/nginx/nginx.conf` (Intel)
   - Test: `sudo nginx -t`
   - Reload: `brew services reload nginx`

5. **Set up MySQL database:**
   ```sql
   CREATE DATABASE cis3760;
   USE cis3760;
   CREATE TABLE coursesDB (
       courseCode VARCHAR(20),
       courseName VARCHAR(255),
       prerequisites TEXT,
       restrictions TEXT
   );
   LOAD DATA INFILE '/path/to/parsed_courses.csv'
   INTO TABLE coursesDB
   FIELDS TERMINATED BY ','
   LINES TERMINATED BY '\n'
   IGNORE 1 ROWS;
   ```

6. **Copy HTML files:**
   ```bash
   cp -r sprint9/sprint9-files/html /opt/homebrew/var/www/
   ```

7. **Access application:**
   - Homepage: http://localhost:8082/
   - API test: http://localhost:8082/courses/getAllCourses/

### AWS Deployment

#### EC2 Setup
1. Launch Ubuntu Server EC2 instance
2. Configure security groups (HTTP: 80, HTTPS: 443, SSH: 22)
3. SSH into instance: `ssh -i key.pem ubuntu@<public-ip>`

#### Software Installation
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install nginx php-fpm php-mysql php-cli mysql-server -y
sudo systemctl start nginx
sudo systemctl start php8.3-fpm
sudo systemctl start mysql
```

#### Configuration
1. Copy Nginx config to `/etc/nginx/sites-available/3760website`
2. Create symlink: `sudo ln -s /etc/nginx/sites-available/3760website /etc/nginx/sites-enabled/`
3. Clone repository: `git clone https://github.com/Simar710/EduGraph.git`
4. Copy files: `sudo cp -r EduGraph/sprint9/sprint9-files/html /var/www/`
5. Set permissions: `sudo chown -R www-data:www-data /var/www/html/`
6. Restart Nginx: `sudo systemctl restart nginx`

---

## Project Evolution (Sprint-based Development)

### **Sprint 1-2:** Foundation
- Python CLI for parsing course data
- Searcher CLI for querying courses
- Excel VBA UI for eligibility checking
- CSV data export

### **Sprint 3-4:** Web Integration
- Basic web interface
- MySQL database setup
- Initial PHP REST APIs
- Team member pages

### **Sprint 5-7:** API Enhancement
- Expanded API endpoints
- Code refactoring
- Bootstrap integration
- Improved UI responsiveness
- Automated testing with Selenium

### **Sprint 6:** Advanced Features
- Full-stack course recommendation system
- Self-designed APIs for recommendations
- Enhanced filtering logic

### **Sprint 8:** Visualization & Performance
- Vis.js prerequisite graphs and trees
- Dark mode implementation
- Performance optimization
- CI/CD pipeline setup

### **Sprint 9:** Polish & Accessibility
- Keyboard navigation
- WCAG 2.1 compliance
- Enhanced dark mode
- API documentation page
- Consistent UI design
- Deployment automation

---

## Testing Strategy

### Test-Driven Development (TDD)
- Detailed test plans for each sprint
- Test cases documented in `TestCases.md` files
- Both manual and automated testing

### Selenium Automated Tests
- **Sprint7.side:** Core functionality tests
- **Tree_Generator.side:** Tree generation tests
- **All_course_Tree.side:** Comprehensive tree tests (long-running)

### Test Execution
- Headless Chrome for CI/CD
- Manual testing in Safari and Chrome
- Cross-browser compatibility verification

### API Testing
- Manual testing with JSON request/response validation
- Copy table (`coursesDBCopy`) for testing POST/PUT/DELETE without affecting production data
- HTTP status code verification

---

## File Structure Overview

```
EduGraph/
├── .github/
│   └── workflows/
│       └── ci-cd.yml          # GitHub Actions CI/CD config
├── .gitlab-ci.yml             # GitLab CI/CD config
├── parser/
│   ├── main.py                # Course data parser
│   ├── README.md
│   └── parsed_courses.csv
├── searcher/
│   ├── search.py              # Course search CLI
│   └── README.md
├── VBASprint2/
│   ├── parsed_courses.xlsm    # Excel VBA UI
│   └── README.md
├── sprint9/
│   ├── sprint9-files/
│   │   └── html/              # Web application files
│   │       ├── index.php      # Homepage
│   │       ├── index.css      # Global styles
│   │       ├── db_connection.php
│   │       ├── get_*.php      # GET API endpoints
│   │       ├── post_courses.php
│   │       ├── put_dbInfo.php
│   │       ├── delete_course_by_code.php
│   │       ├── apidocs.php    # API documentation page
│   │       ├── course_generator/
│   │       │   ├── index.php  # Course recommendation UI
│   │       │   ├── generate_recommendations.php
│   │       │   └── genTree/
│   │       │       └── index.php  # Tree visualization UI
│   │       └── [team_member_pages]/
│   └── sprint9_docs/
│       ├── API.md             # API documentation
│       ├── userStories_sprint9.md
│       ├── test_cases_sprint9.md
│       ├── local_dev.md
│       └── Testing-UI/
│           └── *.side         # Selenium test files
├── Demo_Videos/
│   └── demo_videos.md
├── Photos/
│   └── README.md
├── f23_courses1.txt           # Raw course data
├── f23_courses2.txt
└── README.md                  # Main project documentation
```

---

## Security Considerations

### Database Security
- Parameterized queries to prevent SQL injection
- Separate copy table for testing operations
- Connection credentials management

### Input Validation
- Course code format validation
- JSON payload validation
- Error handling for malformed requests

### HTTP Security
- Proper HTTP method enforcement
- CORS considerations
- Status code-based error responses

### Server Security
- AWS security groups for firewall rules
- SSH key-based authentication
- Regular security updates

---

## Performance Optimizations

### Database
- Indexed columns for faster queries
- Efficient query patterns (WHERE clauses)
- Connection pooling via PHP-FPM

### Frontend
- CDN-hosted libraries (Bootstrap, jQuery, Vis.js)
- Minified CSS/JS resources
- Lazy loading for images
- Local storage for dark mode preference

### API
- JSON response format (lightweight)
- Appropriate HTTP caching headers
- Efficient PHP-FPM process management

### Tree Generation
- Note: All courses tree generation is resource-intensive (2-5 minutes)
- Client-side rendering with Vis.js physics simulation
- Progressive rendering for large datasets

---

## Limitations & Known Issues

1. **Platform-specific VBA:** Excel UI only works on Windows due to ActiveX RegEx dependency
2. **AWS Cost:** Production deployment may be terminated due to resource costs on basic plan
3. **Tree Generation Performance:** All-courses tree takes several minutes to render
4. **Browser Compatibility:** Optimal performance in Chrome/Safari, may vary in other browsers
5. **Database Credentials:** Hardcoded in `db_connection.php` (should use environment variables)

---

## Future Enhancements & Considerations

1. **User Authentication:** Add login system for personalized recommendations
2. **Course History Tracking:** Store student progress over time
3. **Mobile App:** Native mobile applications for iOS/Android
4. **Degree Planning:** Multi-semester course planning tool
5. **Real-time Updates:** WebSocket integration for live course availability
6. **Environment Variables:** Externalize configuration (database credentials, API URLs)
7. **Docker Deployment:** Containerization for easier deployment and scaling
8. **GraphQL API:** Alternative to REST for more flexible data fetching
9. **Progressive Web App (PWA):** Offline functionality and app-like experience
10. **Advanced Analytics:** Course popularity trends, prerequisite complexity analysis

---

## Key Learnings & Best Practices Demonstrated

1. **Agile Development:** Sprint-based iterative development
2. **Version Control:** Effective use of Git branches for feature development
3. **Documentation:** Comprehensive README and API documentation
4. **Testing:** Automated testing with Selenium for regression prevention
5. **Accessibility:** WCAG 2.1 compliance for inclusive design
6. **CI/CD:** Automated deployment and testing pipelines
7. **RESTful Design:** Proper REST API architecture with appropriate HTTP methods
8. **Separation of Concerns:** Clear separation between data processing, API, and UI layers
9. **Responsive Design:** Mobile-first approach with Bootstrap
10. **User Experience:** Dark mode, keyboard navigation, and intuitive interfaces

---

## Conclusion

EduGraph demonstrates a complete full-stack development lifecycle, from data parsing and storage to interactive web visualization with modern web technologies. The project showcases proficiency in:

- **Backend:** PHP, MySQL, Python
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap
- **Infrastructure:** Nginx, AWS EC2, PHP-FPM
- **DevOps:** GitHub Actions, GitLab CI/CD, Selenium
- **Visualization:** Vis.js network graphs
- **Accessibility:** WCAG 2.1 standards
- **API Design:** RESTful architecture

The progressive development through 9 sprints illustrates effective project management, continuous improvement, and commitment to delivering a high-quality, accessible, and functional web application for educational purposes.
