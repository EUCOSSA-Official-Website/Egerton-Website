<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'year', 'semester', 'amount'];


    // Logic To Determin the Current Semester 
    public static function getCurrentSemester() {
        $currentMonth = date('n'); // Month as a number (1-12)
        $year = date('Y');
    
        if ($currentMonth >= 9 && $currentMonth <= 12) {
            return ['semester' => 'Fall', 'year' => $year];
        } elseif ($currentMonth >= 1 && $currentMonth <= 4) {
            return ['semester' => 'Spring', 'year' => $year];
        }
        return null; // Outside of semester periods
    }


    // Logic to Determine if A user has contributed in the Current Semester 
    public function hasContributed($userId) {
        $currentSemester = $this->getCurrentSemester();
        if ($currentSemester) {
            return self::where('user_id', $userId)
                ->where('year', $currentSemester['year'])
                ->where('semester', $currentSemester['semester'])
                ->exists();
        }
        return false;
    }
}
