# Workify 🚀

Workify is a comprehensive, two-sided job board and recruitment platform designed to seamlessly connect job seekers with potential employers. Built with modern web technologies, it offers a dedicated, streamlined experience tailored specifically to the needs of both candidates and companies.

## 📖 Project Idea
The recruitment process is often fragmented. Workify bridges the gap by providing an integrated ecosystem:
- **Job Seekers** can accurately represent their granular skill sets alongside their applications.
- **Employers** can easily post jobs with specific tags and filter candidates effectively.
- **Direct Messaging** allows both parties to communicate within the platform, preventing lost context and slow hiring pipelines.

## ✨ Features
### For Job Seekers
- **Profile Building:** Add technical and soft skills with specific proficiency levels.
- **Job Discovery:** Explore job postings, filter by tags/skills, and apply with a single click.
- **Application Tracking:** Manage active applications and withdraw if no longer interested.
- **Inbox:** Receive and reply to direct messages from prospective employers.

### For Employers
- **Job Management:** Draft, post, and delete job listings with detailed requirements.
- **Application Review:** A dashboard to review applications, viewing applicant details and explicitly accepting or rejecting candidates.
- **Candidate Outreach:** Browse seeker profiles and utilize the platform's messaging system to send direct messages to promising talent.

## 🏗️ Architecture & Tech Stack
- **Backend:** [Laravel 12](https://laravel.com/) (PHP 8.2) for its robust ecosystem, expressive Eloquent ORM, and secure routing.
- **Frontend:** [Tailwind CSS](https://tailwindcss.com/) paired with [Vite](https://vitejs.dev/) and [Alpine.js](https://alpinejs.dev/).
- **Database Schema:** Features a polymorphic-style role-based access control. A central `User` model handles authentication, delegating role-specific attributes to `Employer` or `Seeker` models based on the user's identity.
- **Relational Integrity:** Heavy use of pivot tables (e.g., `seeker_skill` with proficiency, `post_tag`) to maintain complex querying capabilities.

## 🚀 Setup & Installation
To run Workify locally, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Crypt212/workify.git
   cd workify
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node dependencies:**
   *(Note: Ensure you resolve any git conflicts in `package.json` before running)*
   ```bash
   npm install
   ```

4. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup:**
   Configure your `.env` file with your database credentials (e.g., SQLite, MySQL, or PostgreSQL).
   ```bash
   php artisan migrate
   ```

6. **Run the development servers:**
   ```bash
   # In one terminal
   php artisan serve

   # In another terminal
   npm run dev
   ```

## 💡 Usage Guide
1. Navigate to the application URL (e.g., `http://localhost:8000`).
2. Click **Register** to create an account. You must select your identity: **Employer** or **Seeker**.
3. **Employers:** Head to your dashboard to complete your organization profile and start creating job posts.
4. **Seekers:** Complete your profile by adding your professional role and skills, then head to the Job Explorer to start applying.

## 🛣️ Roadmap & Known Issues
This project represents a Minimum Viable Product (MVP). Future architectural improvements include:
- Implementing secure Resume (PDF) and Profile Avatar file uploads.
- Upgrading authorization policies (Laravel Gates) to secure application review endpoints.
- Refactoring the application decision system to use a `status` column instead of destructive deletion to preserve historical candidate data.
- Integrating Email Verification to prevent spam accounts.

---
*Developed for a robust and dynamic job recruitment experience.*
