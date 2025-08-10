MAIN TASKS:
- [ ] Create the dashboard views and controllers
    - [ ] add view for username
    - [ ] add CRUD operations for user information section (name, contact, organization_name if employer, role if seeker)
    - [ ] add CRUD operations for seekers_skills (on seeker dashboard only), seeker can view skils, add new skills with skill_name and skill_proficiency, remove skills.
    - [ ] add CRUD operations for user security info (new password with confirmation).
    - [ ] add buttons with links to other pages as in the framewire.

- [ ] Craete the applications view and controller **employer users** so employers can accept or reject seekers applications
    - [ ] add the applications cards, must have (job_title, seeker_name, seeker_role, seeker_skills, link to seeker_profile)
    - [ ] add pagination and filters.

- [ ] Craete the "post-explore" view and controller for **seeker users** so they can apply or unapply to employers job posts
    - [ ] add the job post cards, must have (job_title, job_tags, job_description, job_skills, employer_name, employer_organization, link to employer_profile)
    - [ ] add pagination and filters.

- [ ] Create "inbox" view and controller for **seeker users** so they can recieve messages from employers
    - [ ] add the mail cards, must have header (employer_name, employer_email, link to employer_profile) and body (mail from employer)
    - [ ] add pagination and filters.

- [ ] Create "applications" view and controller for **seeker users** so they can view their own applications to jobs
    - [ ] add the application card, must have (employer_name, employer_email, link to employer_profile, job_title, job_description, job_skills) 
    - [ ] add remove button so they can unapply to that job
    - [ ] add pagination and filters.

- [ ] Create "profile" view and controller for **seeker users** so they can view employer profiles
    - [ ] it must have all info about them (username, email, name, contact_number, organization_name).

BONUS TASKS:
- [ ] Add users images to database.
- [ ] Add images to profiles.
