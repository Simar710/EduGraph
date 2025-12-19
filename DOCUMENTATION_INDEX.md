# EduGraph Documentation Index

Welcome to the EduGraph documentation! This repository contains comprehensive documentation about the project's technology stack, architecture, and usage.

## 📚 Documentation Overview

This documentation analysis was created to provide a complete understanding of what EduGraph does, how it works, and which technologies it uses for various purposes.

---

## 📖 Available Documentation

### 1. **QUICK_REFERENCE.md** 
**Start here for a quick overview!**

- **Length:** ~380 lines
- **Best for:** Getting started, quick lookups, command reference
- **Contains:**
  - Visual ASCII architecture diagrams
  - Technology stack summary tables
  - Component overview with purposes
  - Quick start guides (local + AWS)
  - Common commands and workflows
  - Feature checklists
  - Directory structure visualization
  - Key metrics and statistics

**When to use:** When you need a quick answer or overview without diving deep into technical details.

---

### 2. **TECHNOLOGY_ANALYSIS.md**
**Complete technical deep-dive!**

- **Length:** ~724 lines
- **Best for:** Understanding architecture, implementation details, making technical decisions
- **Contains:**
  - Comprehensive technology stack breakdown with detailed usage explanations
  - Complete REST API documentation (all 11 endpoints)
  - Data flow architecture with diagrams
  - Development environment setup guides (local + AWS with full commands)
  - Security considerations and best practices
  - Performance optimization strategies
  - Project evolution through 9 sprints
  - Testing strategy (TDD + Selenium)
  - File structure deep-dive
  - Limitations and known issues
  - Future enhancement suggestions
  - Key learnings and takeaways

**When to use:** When you need detailed technical information, want to understand implementation decisions, or need to set up a development environment.

---

### 3. **Original Repository Documentation**

#### **README.md** (Repository Root)
- Project overview and introduction
- Live website link and demo videos
- Setup instructions for MySQL, PHP, and Nginx
- AWS deployment guide
- Sprint-by-sprint progress summary
- Directory structure information

#### **API.md** (`sprint9/sprint9_docs/API.md`)
- Detailed REST API endpoint documentation
- Request/response examples with JSON
- HTTP status codes
- Query parameter specifications
- Error handling examples

#### **Component-Specific READMEs:**
- `parser/README.md` - Python parser documentation
- `searcher/README.md` - Python searcher CLI documentation
- `VBASprint2/README.md` - Excel VBA UI documentation

#### **Sprint Documentation** (`sprint9/sprint9_docs/`)
- `userStories_sprint9.md` - User stories and acceptance criteria
- `test_cases_sprint9.md` - Test cases and scenarios
- `local_dev.md` - Local development setup
- `mysql_use.md` - MySQL usage guide
- `Testing-UI/howToTest.md` - Testing instructions

---

## 🎯 What Does EduGraph Do?

**EduGraph is a full-stack web application designed to help University of Guelph students navigate course prerequisites and plan their academic journey.**

### Core Functionality:
1. **Parse Course Data** - Extract course information from text files
2. **Store in Database** - Organize courses in MySQL
3. **Provide APIs** - 11 REST endpoints for querying course data
4. **Recommend Courses** - Suggest courses based on completed prerequisites
5. **Visualize Prerequisites** - Interactive graphs showing course relationships
6. **Search Courses** - Multiple search criteria and filters

### Live Demo:
- **Website:** http://34.201.123.35/
- **Note:** May be terminated based on AWS resource consumption

---

## 🛠️ Technology Stack Summary

### Backend:
- **Python** - Data parsing and CLI tools
- **PHP** - REST API implementation
- **MySQL** - Database storage
- **Nginx** - Web server
- **PHP-FPM** - Process management

### Frontend:
- **HTML5/CSS3/JavaScript** - Core web technologies
- **Bootstrap 5** - Responsive UI framework
- **jQuery** - AJAX and DOM manipulation
- **Vis.js** - Graph visualization library
- **Font Awesome** - Icon library

### Infrastructure:
- **AWS EC2** - Cloud hosting (Ubuntu Server)
- **GitHub Actions** - CI/CD pipeline
- **GitLab CI** - Alternative CI/CD pipeline
- **Selenium IDE** - Automated testing

### Additional Tools:
- **VBA** - Excel-based UI (Windows-only)
- **Git/GitHub** - Version control

---

## 🚀 Quick Navigation Guide

### I want to...

#### **Understand what technologies are used and why**
→ Read **TECHNOLOGY_ANALYSIS.md** - Section "Technology Stack Breakdown"

#### **Get started quickly with development**
→ Read **QUICK_REFERENCE.md** - Section "Quick Start"

#### **Set up local development environment**
→ Read **TECHNOLOGY_ANALYSIS.md** - Section "Development Environment Setup"  
→ Or **README.md** - "Setting up MySQL, PHP, and NGINX"

#### **Deploy to AWS**
→ Read **TECHNOLOGY_ANALYSIS.md** - Section "AWS Deployment"  
→ Or **README.md** - "Deploying a PHP Website on AWS"

#### **Use the REST APIs**
→ Read **sprint9/sprint9_docs/API.md** - Complete API documentation  
→ Or **TECHNOLOGY_ANALYSIS.md** - Section "REST API Architecture"

#### **Run the Python parser**
→ Read **parser/README.md**

#### **Use the search CLI**
→ Read **searcher/README.md**

#### **Use the Excel VBA UI**
→ Read **VBASprint2/README.md**

#### **Run automated tests**
→ Read **sprint9/sprint9_docs/Testing-UI/howToTest.md**

#### **Understand the project evolution**
→ Read **TECHNOLOGY_ANALYSIS.md** - Section "Project Evolution"  
→ Check individual sprint branches (sprint1-sprint9)

#### **Learn about accessibility features**
→ Read **TECHNOLOGY_ANALYSIS.md** - Section "Accessibility Features"  
→ Or **sprint9/sprint9_docs/userStories_sprint9.md**

#### **See data flow and architecture**
→ Read **TECHNOLOGY_ANALYSIS.md** - Section "Data Flow Architecture"  
→ Or **QUICK_REFERENCE.md** - Section "Data Flow" (visual diagrams)

#### **Understand API endpoints**
→ Read **sprint9/sprint9_docs/API.md** (most detailed)  
→ Or **QUICK_REFERENCE.md** - Section "PHP REST APIs" (quick table)

#### **View demo videos**
→ Read **Demo_Videos/demo_videos.md**

---

## 📊 Documentation Statistics

- **Total Documentation Files:** 15+
- **New Analysis Documents:** 2 (TECHNOLOGY_ANALYSIS.md, QUICK_REFERENCE.md)
- **Total Lines of New Documentation:** 1,100+
- **Technologies Documented:** 20+
- **API Endpoints Documented:** 11
- **Code Examples Included:** Yes (SQL, Bash, PHP, JavaScript, Nginx config)
- **Architecture Diagrams:** Yes (ASCII art in QUICK_REFERENCE.md)

---

## 🎓 Learning Path

### For New Developers:
1. Start with **QUICK_REFERENCE.md** to get an overview
2. Read **README.md** for project introduction
3. Dive into **TECHNOLOGY_ANALYSIS.md** for detailed understanding
4. Follow the setup guides to run locally
5. Explore component-specific READMEs

### For Users:
1. Read **README.md** - Introduction and demo videos
2. Check **Demo_Videos/demo_videos.md** for video tutorials
3. Use the live website: http://34.201.123.35/
4. Read **API.md** if using APIs programmatically

### For Designers/UX:
1. Read **QUICK_REFERENCE.md** - Section "Key Features"
2. Read **sprint9/sprint9_docs/userStories_sprint9.md**
3. Explore accessibility features in **TECHNOLOGY_ANALYSIS.md**

### For DevOps:
1. Read **TECHNOLOGY_ANALYSIS.md** - Sections on CI/CD and AWS
2. Check `.github/workflows/ci-cd.yml` and `.gitlab-ci.yml`
3. Read deployment sections in **README.md**

---

## 🔍 Key Insights from Analysis

### Architecture Highlights:
- **Full-stack application** with clear separation of concerns
- **RESTful API design** with proper HTTP methods and status codes
- **Progressive enhancement** through 9 development sprints
- **Accessibility-first** approach (WCAG 2.1 compliant)
- **Automated deployment** with CI/CD pipelines

### Technology Choices:
- **PHP chosen for** rapid backend development and wide hosting support
- **MySQL used for** structured course data with relationships
- **Python selected for** powerful text parsing with regex
- **Vis.js implemented for** rich graph visualizations
- **Bootstrap adopted for** responsive design out-of-the-box
- **Nginx deployed as** high-performance web server

### Best Practices Demonstrated:
- ✅ Version control with Git
- ✅ Automated testing (Selenium)
- ✅ CI/CD pipelines
- ✅ RESTful API design
- ✅ Responsive web design
- ✅ Accessibility compliance
- ✅ Code documentation
- ✅ Progressive development (sprints)
- ✅ Security considerations
- ✅ Performance optimization

---

## 🤝 Contributing

When contributing to EduGraph:
1. Review the relevant documentation sections
2. Follow the coding standards observed in the codebase
3. Ensure accessibility features are maintained
4. Write tests for new functionality
5. Update documentation as needed

---

## 📞 Support & Resources

- **GitHub Repository:** https://github.com/Simar710/EduGraph
- **Live Demo:** http://34.201.123.35/
- **Demo Videos:** See `Demo_Videos/demo_videos.md`
- **Issues & Questions:** Use GitHub Issues

---

## 📝 Documentation Maintenance

These documentation files were created through comprehensive analysis of the repository:
- **Created:** December 2024
- **Analysis Coverage:** Complete codebase review
- **Technologies Reviewed:** All 20+ technologies and tools
- **Code Files Analyzed:** 100+ files across multiple languages

**Note:** As the project evolves, remember to update:
- API documentation when endpoints change
- Technology analysis when new tools are added
- Quick reference when workflows change
- Setup guides when dependencies change

---

**Happy coding! 🚀**

*For questions about this documentation, refer to the commit history in the repository.*
