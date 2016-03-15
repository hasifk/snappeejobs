<?php

class CustomTableSeeder extends \Illuminate\Database\Seeder
{

    public function run(){

        $uSIinViohancWj52hu = '$uSIinViohancWj52hu';
        $n4N0WiGEKRQIDMUDJGdu0 = '$n4N0WiGEKRQIDMUDJGdu0';

        \DB::statement(
            "
            INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `confirmation_code`, `confirmed`, `remember_token`, `avatar_filename`, `avatar_extension`, `avatar_path`, `about_me`, `country_id`, `state_id`, `dob`, `gender`, `no_password`, `employer_id`, `group_token`, `created_at`, `updated_at`, `deleted_at`, `stripe_active`, `stripe_id`, `stripe_subscription`, `stripe_plan`, `last_four`, `trial_ends_at`, `subscription_ends_at`) VALUES
            (6, 'Employer 1', 'employer1@gmail.com', '$2y$10$uSIinViohancWj52hu.msOWTQ9oMjI85qHJ5G4JG/GPQN2piS.IXq', 1, '08b0e03775b306dcf43434dc7eaad42f', 1, 'shsltrEh32bW7PrJIYdjkJpZsP9v0ZDBIfEPBp3tWESBmvmEznsWBMyedlMo', '', '', '', '', 1, 1, '0000-00-00', '', 1, 6, 'asdasd', '2016-03-07 03:08:35', '2016-03-07 03:18:52', NULL, 1, 'cus_82OlaTABFNAM3s', 'sub_82OlR9gPkqN4g2', 'snappeejobs1', '4242', NULL, NULL),
            (7, 'Job Seeker 1', 'jobseeker1@mail.com', '$2y$10$n4N0WiGEKRQIDMUDJGdu0.afhoNfWBAqvq5PAtDqb2HufCkWYecyy', 1, 'bcb915527c7e342b2d837d4d7d31f65c', 1, 'tHI5nsrdzw0IGEaWyyGqqglE9XNLXGpmrfHg72YoAIkLVULwTKgdvvHWgi95', '12122755_1035809229783745_2617442617398920722_n', 'jpg', 'users/7/avatar/', '', 1, 1, '2016-03-07', 'male', 0, 0, '', '2016-03-07 03:18:20', '2016-03-07 03:51:57', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);
            "
        );

        \DB::statement(
            "
            INSERT INTO `staff_employer` (`id`, `employer_id`, `user_id`, `is_admin`, `created_at`, `updated_at`) VALUES
            (2, 6, 6, 1, '2016-03-07 03:08:35', '2016-03-07 03:08:35');
            "
        );

        \DB::statement(
            "
            INSERT INTO `new_company_temps` (`id`, `employer_id`, `completed`, `created_at`, `updated_at`) VALUES
            (1, 6, 1, '2016-03-07 03:08:36', '2016-03-07 03:16:23');
            "
        );

        \DB::statement(
            "
            INSERT INTO `job_seeker_details` (`id`, `user_id`, `country_id`, `state_id`, `resume_path`, `resume_filename`, `resume_extension`, `size`, `likes`, `has_resume`, `preferences_saved`, `profile_completeness`) VALUES
            (1, 7, 1, 1, 'users/7/resume/', 'First', 'doc', 'small', 0, 1, 1, 5);
            "
        );

        \DB::statement(
            "
            INSERT INTO `job_seeker_industry_preferences` (`id`, `user_id`, `industry_id`, `created_at`, `updated_at`) VALUES
            (1, 1, 1, '2016-03-07 03:28:04', '2016-03-07 03:28:04');
            "
        );

        \DB::statement(
            "
            INSERT INTO `skills_job_seeker` (`id`, `user_id`, `skill_id`, `created_at`, `updated_at`) VALUES
            (1, 1, 1, '2016-03-07 03:28:04', '2016-03-07 03:28:04');
            "
        );

        \DB::statement(
            "
            INSERT INTO `employer_plan` (`id`, `employer_id`, `job_postings`, `staff_members`, `chats_accepted`, `created_at`, `updated_at`) VALUES
            (2, 6, 10, 10, 10, '2016-03-07 03:14:17', '2016-03-07 03:14:17');
            "
        );

        \DB::statement(
            "
            INSERT INTO `category_preferences_job_seeker` (`id`, `user_id`, `job_category_id`, `created_at`, `updated_at`) VALUES
            (1, 1, 1, '2016-03-07 03:28:04', '2016-03-07 03:28:04');
            "
        );

        \DB::statement(
            "
            INSERT INTO `assigned_roles` (`id`, `user_id`, `role_id`) VALUES
            (6, 6, 2),
            (7, 7, 4);
            "
        );

        \DB::statement(
            "
            INSERT INTO `companies` (`id`, `employer_id`, `title`, `url_slug`, `size`, `description`, `what_it_does`, `office_life`, `country_id`, `state_id`, `default_photo_id`, `logo`, `likes`, `new`, `paid`, `paid_expiry`, `created_at`, `updated_at`) VALUES
            (2, 6, 'Employer Company', 'employer-company', 'medium', 'asd\r\nad\r\nsa\r\nassa\r\n\r\ndas\r\nd', 'asd\r\nasd\r\nas\r\n', 'asd\r\nasd\r\nsa\r\n', 2, 51, 0, '', 0, 1, 0, '0000-00-00 00:00:00', '2016-03-07 03:16:23', '2016-03-07 03:16:23');
            "
        );

        \DB::statement(
            "
            INSERT INTO `industry_company` (`id`, `company_id`, `industry_id`, `created_at`, `updated_at`) VALUES
            (4, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
            (5, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
            (6, 2, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
            "
        );

        \DB::statement(
            "
            INSERT INTO `jobs` (`id`, `company_id`, `title`, `title_url_slug`, `level`, `country_id`, `state_id`, `likes`, `description`, `status`, `published`, `paid`, `paid_expiry`, `created_at`, `updated_at`, `deleted_at`) VALUES
            (2, 2, 'Laravel Developer', 'laravel-developer', 'internship', 15, 218, 0, 'asd<br>asda<br>sd', 1, 1, 0, '0000-00-00 00:00:00', '2016-03-07 03:17:22', '2016-03-07 03:17:37', NULL);
            "
        );

        \DB::statement(
            "
            INSERT INTO `category_preferences_jobs` (`id`, `job_id`, `job_category_id`, `created_at`, `updated_at`) VALUES
            (4, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
            (5, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
            "
        );

        \DB::statement(
            "
            INSERT INTO `job_applications` (`id`, `job_id`, `user_id`, `accepted_at`, `accepted_by`, `declined_at`, `declined_by`, `declined_viewed_at`, `created_at`, `updated_at`) VALUES
            (1, 2, 7, NULL, NULL, NULL, NULL, NULL, '2016-03-07 03:36:28', '2016-03-07 03:36:28');
            "
        );

        \DB::statement(
            "
            INSERT INTO `job_prerequisites` (`id`, `job_id`, `content`, `created_at`, `updated_at`) VALUES
            (4, 2, 'asdasdasd', '2016-03-07 03:17:22', '2016-03-07 03:17:22');
            "
        );

        \DB::statement(
            "
            INSERT INTO `job_skills` (`id`, `job_id`, `skill_id`, `created_at`, `updated_at`) VALUES
            (2, 2, 42, '2016-03-07 03:17:22', '2016-03-07 03:17:22'),
            (3, 2, 206, '2016-03-07 03:17:22', '2016-03-07 03:17:22');
            "
        );

    }

}