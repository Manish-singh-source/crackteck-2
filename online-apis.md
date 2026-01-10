
// Sales Person 

1. Send OTP

Link: https://crackteck.co.in/api/v1/send-otp?phone_number=7709131547&role_id=3 

params: 

phone_number: 7709131547
role_id: 3

response: 

{
    "success": true,
    "message": "OTP sent successfully",
    "otp": 3389
}



2. Verify OTP 

Link: https://crackteck.co.in/api/v1/verify-otp?phone_number=7709131547&role_id=3&otp=3389

params: 

phone_number: 7709131547
role_id: 3
otp: 3389


response: 

{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2NyYWNrdGVjay5jby5pbi9hcGkvdjEvdmVyaWZ5LW90cCIsImlhdCI6MTc2ODAzNzU1NywiZXhwIjoxNzk5NTczNTU3LCJuYmYiOjE3NjgwMzc1NTcsImp0aSI6ImxwY2VxWE5sTjIzNGVYd2ciLCJzdWIiOiIzIiwicHJ2IjoiYmNkNmY4YWRhOTgyY2Q2YjAzYzExMTM0YWUyZTE5OGYwNjRmZDkwMyJ9.VEgDNw2yU9466IsRVIQU_Y8eJXANcnLmccEonqKpIWg",
    "user": {
        "id": 3,
        "first_name": "Saurabh",
        "last_name": "Damale",
        "phone": "7709131547",
        "email": "saurabh.damale@example.com",
        "dob": "1989-02-07",
        "gender": "male",
        "employment_type": "Full-time",
        "joining_date": "2020-12-10",
        "assigned_area": "ABC",
        "otp": null,
        "otp_expiry": null,
        "status": "Active",

        "current_address": "Banjara Hills",
        "city": "Hyderabad",
        "state": "Telangana",
        "country": "India",
        "pincode": "500034",

        "vehicle_type": "Bike",
        "vehical_no": "TS07EF3421",
        "driving_license_no": "TSDL23456789",
        "driving_license": null,
        "police_verification": "Yes",
        "police_verification_status": "Completed",
        "police_certificate": null,

        "govid": "Aadhar",
        "idno": "567890123456",
        "adhar_pic": null,
        "bank_acc_no": "234567890123",
        "bank_name": "ICICI Bank",
        "ifsc_code": "ICIC0002345",
        "passbook_pic": null,
        "created_at": "2025-12-10T07:34:17.000000Z",
        "updated_at": "2026-01-10T09:32:37.000000Z"
    }
}




3. Refresh Token 

Link: https://crackteck.co.in/api/v1/refresh-token?user_id=2&role_id=3 

params: 

user_id: 2
role_id: 3


response: 
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2NyYWNrdGVjay5jby5pbi9hcGkvdjEvcmVmcmVzaC10b2tlbiIsImlhdCI6MTc2ODAzNzU1NywiZXhwIjoxNzk5NTczNjE1LCJuYmYiOjE3NjgwMzc2MTUsImp0aSI6IlREM205WEVjSVo5OHlHUHYiLCJzdWIiOiIzIiwicHJ2IjoiYmNkNmY4YWRhOTgyY2Q2YjAzYzExMTM0YWUyZTE5OGYwNjRmZDkwMyJ9.PJsNK-Q7RgMgt7ILNjCNK9mU1WGHyoEHX8YfylYtDc8",
    "token_type": "bearer",
    "expires_in": 31536000
}


4. Logout 

Link: https://crackteck.co.in/api/v1/logout?user_id=3&role_id=3 

params: 

user_id: 3
role_id: 3


response: 

{
    "message": "Successfully logged out"
}



5. List of Leads 

Link: https://crackteck.co.in/api/v1/leads?user_id=2&role_id=3 

params: 

user_id: 2
role_id: 3

response: 

{
    "data": [
        {
            "id": 5,
            "name": "Lenna Cole",
            "phone": "2747594409",
            "email": "wyman.domenick@example.org",
            "dob": "1986-05-08",
            "gender": "female",
            "company_name": "Hahn-Pfannerstill",
            "designation": "Order Filler",
            "industry_type": "pharma",
            "source": "referral",
            "requirement_type": "servers",
            "budget_range": "100K-500K",
            "urgency": "Medium",
            "status": "Contacted",
            "created_at": "2025-12-10 13:04:17",
            "updated_at": "2025-12-10 13:04:17"
        },
        {
            "id": 11,
            "name": "Marguerite Parker2",
            "phone": "8281385393",
            "email": "mparker2@example.com",
            "dob": "2008-04-02",
            "gender": "male",
            "company_name": "Hahn Group",
            "designation": "Driver-Sales Worker",
            "industry_type": "school",
            "source": "event",
            "requirement_type": "biometric",
            "budget_range": "10K-50K",
            "urgency": "Low",
            "status": "Lost",
            "created_at": "2025-12-10 13:04:17",
            "updated_at": "2025-12-10 14:50:22"
        },
    ],
    "links": {
        "first": "https://crackteck.co.in/api/v1/leads?page=1",
        "last": "https://crackteck.co.in/api/v1/leads?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "https://crackteck.co.in/api/v1/leads?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
        ],
        "path": "https://crackteck.co.in/api/v1/leads",
        "per_page": 15,
        "to": 11,
        "total": 11
    }
}


6. Single Lead 

Link: https://crackteck.co.in/api/v1/lead/5?user_id=2   

Params: 

user_id: 2

Response: 

{
    "data": {
        "id": 5,
        "name": "Lenna Cole",
        "phone": "2747594409",
        "email": "wyman.domenick@example.org",
        "dob": "1986-05-08",
        "gender": "female",
        "company_name": "Hahn-Pfannerstill",
        "designation": "Order Filler",
        "industry_type": "pharma",
        "source": "referral",
        "requirement_type": "servers",
        "budget_range": "100K-500K",
        "urgency": "Medium",
        "status": "Contacted",
        "created_at": "2025-12-10 13:04:17",
        "updated_at": "2025-12-10 13:04:17"
    }
}


7. Update Lead 

Link: https://crackteck.co.in/api/v1/lead/11?user_id=2 

Params: 

user_id: 2

Body:  

{
    "full_name": "Marguerite Parker2",
    "phone": "8281385393",
    "email": "mparker2@example.com",
    "dob": "2008-04-02",
    "gender": "male",
    "company_name": "Hahn Group",
    "designation": "Driver-Sales Worker",
    "industry_type": "school",
    "source": "event",
    "requirement_type": "biometric",
    "budget_range": "10K-50K",
    "urgency": "Low",
    "status": "Lost"
}


Response: 

{
    "data": {
        "id": 11,
        "name": "Marguerite Parker2",
        "phone": "8281385393",
        "email": "mparker2@example.com",
        "dob": "2008-04-02",
        "gender": "male",
        "company_name": "Hahn Group",
        "designation": "Driver-Sales Worker",
        "industry_type": "school",
        "source": "event",
        "requirement_type": "biometric",
        "budget_range": "10K-50K",
        "urgency": "Low",
        "status": "Lost",
        "created_at": "2025-12-10 13:04:17",
        "updated_at": "2025-12-10 14:50:22"
    }
}


8. Delete Lead  

Link: https://crackteck.co.in/api/v1/lead/11?user_id=2 

Params: 

user_id: 2

Response: 

{
    "message": "Lead deleted successfully"
} 


9. Create Lead 

Link: https://crackteck.co.in/api/v1/lead 

Body:  

{
    "user_id": 2,
    "name": "Saurabh Damale",
    "company_name": "TechNova Solutions",
    "designation": "Project Manager",
    "phone": "9876543212",
    "email": "saurabh3.damale@example.com",

    "dob": "1990-06-15",
    "gender": "Male",
    
    "address": "MG Road, Andheri East, Mumbai",
    "budget_range": "50,000 - 1,00,000",
    "source": "Google Ads",
    "urgency": "High",
    "requirement_type": "Website Development",
    "industry_type": "IT Services",
    "status": "New"
}

Response: 

{
    "data": {
        "id": 53,
        "name": "Saurabh Damale",
        "phone": "9876543212",
        "email": "saurabh3.damale@example.com",
        "dob": "1990-06-15",
        "gender": "Male",
        "company_name": "TechNova Solutions",
        "designation": "Project Manager",
        "industry_type": "IT Services",
        "source": "Google Ads",
        "requirement_type": "Website Development",
        "budget_range": "50,000 - 1,00,000",
        "urgency": "High",
        "status": "New",
        "created_at": "2026-01-10 15:27:49",
        "updated_at": "2026-01-10 15:27:49"
    }
}


