# API Login and AMC Media Flow

## 1. Email and Password Login

### Endpoint

```http
POST https://srbcomputers.co.in/api/v1/email-pass-login
```

### Request headers

```http
Accept: application/json
Content-Type: application/json
```

### Request body

```json
{
  "email": "user@example.com",
  "password": "user-password",
  "role_id": 1
}
```

### Role IDs

| `role_id` | Role |
|---:|---|
| 1 | Engineer |
| 2 | Delivery Man |
| 3 | Sales Person |
| 4 | Customer |

### Backend flow

1. Laravel validates `email`, `password`, and `role_id`.
2. The user is searched in the `staff` table for roles 1–3.
3. The user is searched in the `customers` table for role 4.
4. The password is checked using Laravel's password hash verification.
5. A JWT token is generated using the correct guard:
   - `staff_api` for staff roles
   - `customer_api` for customers
6. The API returns the token and user details.

### Successful response

```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "JWT_TOKEN",
    "user": {
      "id": 4,
      "email": "user@example.com"
    }
  }
}
```

The exact response may contain the user object at the top level depending on the deployed controller version. The mobile app should read the returned `token` and save it securely.

### Error responses

```json
{
  "success": false,
  "message": "User not found"
}
```

```json
{
  "success": false,
  "message": "Invalid password"
}
```

The app should not call OTP verification after a successful email/password login. It should store the JWT and navigate to the role dashboard.

### Authenticated API requests

Use the token in every protected request:

```http
Authorization: Bearer JWT_TOKEN
Accept: application/json
```

The token should be cleared when logout is successful or when the API returns `401 Unauthorized`.

## 2. Existing Phone OTP Login

Phone login remains a separate flow:

```http
POST /api/v1/send-otp
POST /api/v1/verify-otp
```

Email/password login uses one request and returns a JWT immediately. Phone login first sends an OTP and then requires OTP verification before returning the JWT.

## 3. AMC and Product Images

### Product images in service requests

The service request API already returns product image data under `products`:

```json
{
  "products": [
    {
      "images": "service-request-images/product.jpg",
      "images_url": "https://srbcomputers.co.in/service-request-images/product.jpg"
    }
  ]
}
```

The mobile app should display `images_url`, not the relative `images` path.

### AMC plan media

An AMC plan currently has a `brochure` field, not a dedicated plan-thumbnail image field. The API now adds:

```json
{
  "amcPlan": {
    "plan_name": "Basic AMC",
    "brochure": "uploads/crm/amc/brochure/basic.pdf",
    "brochure_url": "https://srbcomputers.co.in/uploads/crm/amc/brochure/basic.pdf",
    "covered_items_details": []
  }
}
```

Use `brochure_url` for the AMC plan brochure/document. If the app needs a real plan thumbnail image, a separate `image` column and upload field must be added to `amc_plans`; `brochure_url` should not be treated as an image when the file is a PDF.

### Covered item images inside an AMC plan

Each covered item now includes an absolute image URL:

```json
{
  "covered_items_details": [
    {
      "id": 1,
      "service_name": "Repairing",
      "image": "uploads/crm/covered-items/repair.jpg",
      "image_url": "https://srbcomputers.co.in/uploads/crm/covered-items/repair.jpg"
    }
  ]
}
```

The app should render `image_url`.

### AMC API endpoints

```http
GET /api/v1/amc-plans?role_id=4
GET /api/v1/amc-plan-details/{id}?role_id=4
```

### Engineer service request endpoints

```http
GET /api/v1/service-requests?user_id={engineer_id}&role_id=1
GET /api/v1/service-request/{id}?user_id={engineer_id}&role_id=1
```

For engineer service requests, the response now includes:

```text
serviceRequest.amcPlan.brochure_url
serviceRequest.amcPlan.covered_items_details[].image_url
serviceRequest.products[].images_url
```

## 4. Deployment after these changes

```bash
git pull origin main
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
```

The production `.env` must use:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://srbcomputers.co.in
```

Do not return OTP values in production API responses, and do not expose API keys, JWT secrets, database passwords, or mail passwords in logs or documentation.
