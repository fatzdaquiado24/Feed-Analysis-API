<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\LaboratoryAnalysisRequest;

class AppointmentDate extends Model
{
    protected $fillable = [
        'date', 'maximum_appointment'
    ];

    protected $appends = array('appointed');

    public function getAppointedAttribute()
    {
        return LaboratoryAnalysisRequest::where('appointment_date', $this->maximum_appointment)->count();
    }
}
