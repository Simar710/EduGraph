# EduGraph - Quick Reference Guide

## 🎯 What is EduGraph?

A **full-stack web application** for University of Guelph students to:
- 📚 Explore course prerequisites and restrictions
- 🎓 Get personalized course recommendations
- 🌳 Visualize prerequisite relationships as interactive graphs
- 🔍 Search course information via REST APIs

**Live Demo:** http://34.201.123.35/

---

## 🛠️ Technology Stack at a Glance

### Backend
```
┌─────────────────────────────────────┐
│ Python CLI (Parser & Searcher)     │
│  • Parse course text files          │
│  • Generate CSV data                │
└────────────┬────────────────────────┘
             ↓
┌─────────────────────────────────────┐
│ MySQL Database                      │
│  • Database: cis3760                │
│  • Table: coursesDB                 │
└────────────┬────────────────────────┘
             ↓
┌─────────────────────────────────────┐
│ PHP REST APIs                       │
│  • 11 endpoints for CRUD operations │
│  • JSON request/response            │
└─────────────────────────────────────┘
```

### Frontend
```
┌─────────────────────────────────────┐
│ HTML5 + CSS3 + JavaScript           │
│  • Bootstrap 5 (responsive design)  │
│  • jQuery (AJAX & DOM manipulation) │
│  • Vis.js (graph visualization)     │
│  • Dark mode support                │
└─────────────────────────────────────┘
```

### Infrastructure
```
┌─────────────────────────────────────┐
│ Nginx Web Server                    │
│  • Serves static files              │
│  • Routes API requests              │
│  • FastCGI to PHP-FPM               │
└────────────┬────────────────────────┘
             ↓
┌─────────────────────────────────────┐
│ AWS EC2 (Ubuntu Server)             │
│  • Production deployment            │
│  • Public IP: 34.201.123.35         │
└─────────────────────────────────────┘
```

### CI/CD & Testing
```
┌─────────────────────────────────────┐
│ GitHub Actions / GitLab CI          │
│  • Auto-deploy on push              │
│  • Run Selenium tests               │
└────────────┬────────────────────────┘
             ↓
┌─────────────────────────────────────┐
│ Selenium IDE                        │
│  • Automated UI testing             │
│  • Headless Chrome execution        │
└─────────────────────────────────────┘
```

---

## 📊 Key Components

### 1. Python Parser (`parser/main.py`)
- **Input:** Raw text files (`f23_courses1.txt`, `f23_courses2.txt`)
- **Process:** Regex-based parsing of course information
- **Output:** CSV file (`parsed_courses.csv`)
- **Features:**
  - Extracts course codes, names, prerequisites, restrictions
  - Handles complex prerequisite logic (AND/OR)
  - Filters duplicate courses

### 2. Python Searcher (`searcher/search.py`)
- **Input:** CSV from parser
- **Interface:** CLI menu
- **Search Options:**
  1. Course Name Search
  2. Subject Search (e.g., all CIS courses)
  3. Course Code Search (e.g., CIS*1300)

### 3. VBA Excel UI (`VBASprint2/parsed_courses.xlsm`)
- **Purpose:** Offline course eligibility checker
- **Input:** Student's completed courses and credits
- **Process:** VBA macros parse prerequisites and check eligibility
- **Output:** List of courses student can take
- **Limitation:** Windows-only (uses ActiveX RegEx)

### 4. PHP REST APIs (`sprint9/sprint9-files/html/*.php`)

#### Core Endpoints:
| HTTP Method | Endpoint | Purpose |
|-------------|----------|---------|
| GET | `/courses/getAllCourses/` | Get all courses |
| GET | `/courses/getSubjects/` | Get all subjects |
| POST | `/courses/getCourseByCode/` | Get course by code |
| POST | `/courses/getCourseByName/` | Fuzzy search by name |
| POST | `/courses/getCoursesByPrereq/` | Filter by prerequisites |
| POST | `/courses/getCoursesByRestrictions/` | Filter by restrictions |
| POST | `/courses/postCourses/` | Add new course |
| PUT | `/courses/update/` | Update course |
| DELETE | `/courses/delete/` | Delete course |

#### API Features:
- ✅ JSON format
- ✅ HTTP status codes (200, 400, 404, 405, 500)
- ✅ Fuzzy search
- ✅ Boolean logic (AND/OR)
- ✅ Case-insensitive

### 5. Web Application (`sprint9/sprint9-files/html/`)

#### Main Pages:
1. **Homepage** (`index.php`)
   - Team information
   - Download course file
   - API documentation link

2. **Course Generator** (`course_generator/index.php`)
   - Input completed courses
   - Get personalized recommendations
   - Search course information

3. **Tree Generator** (`course_generator/genTree/index.php`)
   - Select subject or all courses
   - Generate interactive prerequisite graphs
   - Search within tree
   - Download tree as image

#### Features:
- 🌙 Dark mode with localStorage persistence
- ⌨️ Keyboard navigation (WCAG 2.1 compliant)
- 📱 Responsive design (Bootstrap grid)
- 🎨 Consistent color palette
- ♿ Accessibility features (ARIA labels, semantic HTML)

### 6. Visualization with Vis.js
- **Purpose:** Interactive prerequisite graphs
- **Features:**
  - Hierarchical tree layout
  - Node clicking for course details
  - Physics simulation for graph arrangement
  - Zoom and pan controls
  - Search and highlight functionality
  - Download as image
- **Performance:** All-courses tree takes 2-5 minutes to render

---

## 🔄 Data Flow

### Complete Application Flow:
```
Raw Text → Python Parser → CSV → MySQL → PHP API → JSON → JavaScript → Vis.js → User
```

### User Interaction Flow:
```
1. User enters completed courses
2. JavaScript sends AJAX request to PHP API
3. PHP queries MySQL with OR logic
4. MySQL returns courses where prerequisites are met
5. PHP filters and returns JSON response
6. JavaScript displays recommendations
```

### Deployment Flow:
```
1. Developer commits code
2. GitHub/GitLab detects push to sprint9 branch
3. CI/CD pipeline triggered
4. Code deployed to AWS EC2
5. Selenium tests run automatically
6. Results reported
```

---

## 🚀 Quick Start

### Local Development (macOS/Linux):

```bash
# 1. Install dependencies
brew install mysql php nginx

# 2. Start services
brew services start mysql
brew services start php
brew services start nginx

# 3. Set up database
mysql -u root
> CREATE DATABASE cis3760;
> USE cis3760;
> CREATE TABLE coursesDB (
    courseCode VARCHAR(20),
    courseName VARCHAR(255),
    prerequisites TEXT,
    restrictions TEXT
  );
> LOAD DATA INFILE '/path/to/parsed_courses.csv' INTO TABLE coursesDB...;

# 4. Copy files
cp -r sprint9/sprint9-files/html /opt/homebrew/var/www/

# 5. Configure Nginx
sudo nginx -t
brew services reload nginx

# 6. Access application
open http://localhost:8082/
```

### AWS Deployment:

```bash
# 1. SSH to EC2
ssh -i key.pem ubuntu@<public-ip>

# 2. Install LEMP stack
sudo apt update && sudo apt install nginx php-fpm php-mysql mysql-server -y

# 3. Clone and deploy
git clone https://github.com/Simar710/EduGraph.git
sudo cp -r EduGraph/sprint9/sprint9-files/html /var/www/

# 4. Configure Nginx
sudo ln -s /etc/nginx/sites-available/3760website /etc/nginx/sites-enabled/
sudo systemctl restart nginx

# 5. Access via public IP
http://<public-ip>/
```

---

## 📁 Directory Structure

```
EduGraph/
├── parser/                    # Python course data parser
├── searcher/                  # Python course searcher CLI
├── VBASprint2/               # Excel VBA UI
├── sprint9/
│   ├── sprint9-files/html/   # Web application
│   │   ├── *.php             # API endpoints
│   │   ├── *.css             # Stylesheets
│   │   ├── course_generator/ # Recommendation system
│   │   │   └── genTree/      # Tree visualization
│   │   └── [team_pages]/     # Team member pages
│   └── sprint9_docs/         # Documentation
│       ├── API.md
│       └── Testing-UI/       # Selenium tests
├── .github/workflows/        # GitHub Actions CI/CD
├── .gitlab-ci.yml           # GitLab CI/CD
└── README.md                # Main documentation
```

---

## 🎨 Tech Stack Summary

| Layer | Technologies |
|-------|-------------|
| **Data Processing** | Python 3, Regular Expressions, CSV |
| **Database** | MySQL |
| **Backend** | PHP, PHP-FPM |
| **Web Server** | Nginx |
| **Frontend** | HTML5, CSS3, JavaScript, jQuery |
| **UI Framework** | Bootstrap 5 |
| **Visualization** | Vis.js Network Library |
| **Icons/Fonts** | Font Awesome 5, Google Fonts |
| **Cloud** | AWS EC2 (Ubuntu) |
| **CI/CD** | GitHub Actions, GitLab CI |
| **Testing** | Selenium IDE, TDD |
| **Version Control** | Git, GitHub |
| **Office** | VBA (Excel Macros) |

---

## 📝 Development Timeline (9 Sprints)

**Sprint 1-2:** Python CLI + VBA UI + CSV parsing  
**Sprint 3-4:** Web interface + MySQL + Basic APIs  
**Sprint 5-7:** Enhanced APIs + Bootstrap + Testing  
**Sprint 6:** Course recommendation system  
**Sprint 8:** Vis.js graphs + Dark mode + CI/CD  
**Sprint 9:** Accessibility + Keyboard nav + Polish  

---

## 🎯 Key Features

### For Students:
- ✅ Find eligible courses based on completed work
- ✅ Visualize course prerequisite chains
- ✅ Search courses by multiple criteria
- ✅ Plan academic journey effectively

### For Developers:
- ✅ RESTful API with 11 endpoints
- ✅ JSON request/response format
- ✅ Automated deployment pipeline
- ✅ Selenium test suite
- ✅ Well-documented codebase

### For Accessibility:
- ✅ WCAG 2.1 compliant
- ✅ Keyboard navigation
- ✅ Screen reader support (ARIA labels)
- ✅ Dark mode option
- ✅ High contrast theme

---

## 🔐 Security Features

- ✅ Parameterized SQL queries (prevent injection)
- ✅ Input validation
- ✅ HTTP method enforcement
- ✅ AWS security groups
- ✅ SSH key authentication
- ✅ Separate test database table

---

## 📊 Performance Considerations

- ⚡ CDN-hosted libraries
- ⚡ PHP-FPM process pooling
- ⚡ Database indexing
- ⚡ Local storage caching
- ⚡ Minified resources
- ⚠️ Note: All-courses tree is resource-intensive (2-5 min)

---

## 🐛 Known Limitations

1. VBA UI only works on Windows
2. AWS deployment may be terminated (cost reasons)
3. All-courses tree generation is slow
4. Database credentials hardcoded
5. Best performance in Chrome/Safari

---

## 🚀 Future Enhancements

- [ ] User authentication system
- [ ] Multi-semester degree planning
- [ ] Mobile native apps
- [ ] Docker containerization
- [ ] GraphQL API
- [ ] Progressive Web App (PWA)
- [ ] Real-time course availability
- [ ] Advanced analytics dashboard

---

## 📚 Documentation

- **Main README:** `/README.md`
- **Tech Analysis:** `/TECHNOLOGY_ANALYSIS.md` (this is the comprehensive 700+ line document)
- **API Docs:** `/sprint9/sprint9_docs/API.md`
- **User Stories:** `/sprint9/sprint9_docs/userStories_sprint9.md`
- **Test Cases:** `/sprint9/sprint9_docs/test_cases_sprint9.md`
- **Demo Videos:** `/Demo_Videos/demo_videos.md`

---

## 🤝 Team

- Emily Kozatchiner (Team Lead)
- Sara Adi
- Maneesh K. Wijewardhana
- Fee Kim Ah-Poa
- Simardeep Singh

---

## 📞 Support

For detailed technical information, see `TECHNOLOGY_ANALYSIS.md` (724 lines of comprehensive documentation covering every aspect of the technology stack, architecture, and implementation details).

---

**Built with ❤️ for the University of Guelph academic community**
