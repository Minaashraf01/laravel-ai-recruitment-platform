# Laravel AI Recruitment Platform

AI-powered recruitment platform built with Laravel MVC architecture.

This project is a monorepo-based recruitment system that allows users to apply for jobs, upload CVs, and receive AI-generated feedback based on how well their CV matches the job description.

The system also provides an admin and company dashboard to manage jobs, companies, and applicants.

This project integrates OpenAI API to analyze CV content and generate evaluation results including strengths, weaknesses, suitability, and a score out of 100.

---

##  Features

###  User Application (job-app)

- Browse available jobs
- Apply for jobs
- Upload CV
- AI-powered CV analysis
- Compare CV with job description
- Get feedback
- Get strengths & weaknesses
- Get score out of 100
- Check candidate suitability

---

###  Admin Dashboard (job-backoffice)

Admin can:

- Manage companies
- Manage jobs
- View all applicants
- View candidate CV
- View AI feedback
- View score results
- Monitor system activity

---

###  Company Owner Dashboard

Company owner can:

- Add new job posts
- View applicants for company jobs
- View CV files
- View score results
- View feedback
- Check candidate suitability

---

###  Shared Code (job-shared)

Contains shared logic between applications:

- Models
- Services
- Helpers
- Shared business logic

---

##  AI Workflow

1. User uploads CV
2. CV content is extracted
3. Job description is loaded
4. CV is compared with job description
5. OpenAI API analyzes the data
6. System returns:

- Suitability result
- Strengths
- Weaknesses
- Score out of 100
- Feedback

---

