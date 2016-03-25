<?php

namespace App\Models\JobSeeker;

use App\Models\JobSeeker\Traits\Attribute\VideoLinkAttribute;
use Illuminate\Database\Eloquent\Model;

class JobSeekerVideoLinks extends Model
{
    use VideoLinkAttribute;
    protected $table = 'job_seeker_video_links';

    protected $guarded = ['id'];


}
