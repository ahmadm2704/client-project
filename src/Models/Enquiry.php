<?php

namespace App\Models;

class Enquiry extends BaseModel
{
    protected static $table = 'enquiries';

    public static function getEnquiriesByCourse($courseId)
    {
        try {
            return static::findAllBy('course_id', $courseId);
        } catch (\Exception $e) {
            error_log('getEnquiriesByCourse error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getEnquiriesByStatus($status)
    {
        try {
            return static::findAllBy('status', $status);
        } catch (\Exception $e) {
            error_log('getEnquiriesByStatus error: ' . $e->getMessage());
            return [];
        }
    }

    public static function createEnquiry($name, $email, $phone, $courseId, $message)
    {
        try {
            return static::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'course_id' => $courseId,
                'message' => $message,
                'status' => 'new',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            error_log('createEnquiry error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function respondToEnquiry($enquiryId, $respondedBy)
    {
        try {
            return static::updateRecord($enquiryId, [
                'status' => 'responded',
                'responded_by' => $respondedBy,
                'responded_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            error_log('respondToEnquiry error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function closeEnquiry($enquiryId)
    {
        try {
            return static::updateRecord($enquiryId, [
                'status' => 'closed'
            ]);
        } catch (\Exception $e) {
            error_log('closeEnquiry error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function getNewEnquiries()
    {
        try {
            return static::findAllBy('status', 'new');
        } catch (\Exception $e) {
            error_log('getNewEnquiries error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getEnquiriesByEmail($email)
    {
        try {
            return static::findAllBy('email', $email);
        } catch (\Exception $e) {
            error_log('getEnquiriesByEmail error: ' . $e->getMessage());
            return [];
        }
    }
}
