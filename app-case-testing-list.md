# App Case Testing Checklist

# 1. App launch and setup

## Splash / startup

- App opens without crash
- Splash screen shows correctly
- App redirects to correct screen based on login state
- App handles no internet on startup
- App handles slow internet on startup
- App loads remote config / initial API data correctly

## Environment setup

- App points to correct API base URL
- Staging and production configs work properly
- Firebase initializes correctly
- Push notification permission prompt appears where required

# 2. Authentication

## Login

- User can log in with valid credentials
- Login fails with invalid credentials
- Validation message shows for empty fields
- Validation message shows for invalid phone/email format
- Loading state appears during login
- Multiple taps on login button do not create duplicate requests
- JWT/token is stored after successful login
- User stays logged in after app restart
- Expired token is handled correctly
- Unauthorized API response redirects user to login when needed

## OTP login / verification

- OTP is sent successfully for valid phone number
- OTP fails for invalid/non-existing number
- OTP input accepts correct format
- Correct OTP logs user in
- Wrong OTP shows proper error
- Expired OTP shows proper error
- OTP resend works after timer ends
- OTP cannot be resent before timer ends
- Multiple OTP requests do not break flow

## Logout

- User can log out successfully
- Token/session is removed after logout
- Protected screens are inaccessible after logout
- FCM token is removed or updated correctly on logout if required

# 3. User registration / profile

## Registration

- New user can register with valid data
- Required field validation works
- Duplicate email/phone is rejected
- Password rules work correctly
- Role-based registration works correctly
- Error messages are user-friendly

## Profile

- User profile loads correctly
- User can update name, phone, email, profile image
- Invalid profile update shows validation errors
- Profile changes persist after app restart
- Old profile data is not shown after successful update

# 4. API testing for Laravel backend

## General API behavior

- API returns correct success status codes
- API returns correct validation error status codes
- API returns correct unauthorized status codes
- API returns proper error message format
- API handles missing parameters correctly
- API handles invalid parameter types correctly
- API handles null values correctly
- API handles large payload safely
- API response time is acceptable
- API returns consistent JSON structure

## Authentication APIs

- Login API returns token correctly
- Verify OTP API returns token and user correctly
- Refresh token API works correctly
- Expired token returns proper error
- Invalid token returns proper error
- Logged-out token cannot access protected routes

## CRUD APIs

For every create/read/update/delete endpoint:

- Create works with valid payload
- Create fails with invalid payload
- Read list returns correct data
- Read detail returns correct record
- Update works with valid data
- Update fails with invalid data
- Delete works correctly
- Deleted data no longer appears in list
- Unauthorized user cannot access restricted records
- Role-based restrictions work correctly

# 5. Role and permission testing

- Customer cannot access staff APIs
- Staff cannot access admin-only APIs
- Delivery user can only access delivery-related APIs
- Role-based menu items show correctly in Flutter
- Role-based redirects work correctly after login
- Forbidden APIs return correct message/status

# 6. UI and UX testing

- All screens render correctly on small screens
- All screens render correctly on large screens
- Text does not overflow
- Buttons are clickable and aligned properly
- Keyboard does not hide important fields
- Forms scroll correctly
- Loading indicators show during API requests
- Empty state UI is shown where applicable
- Error state UI is shown where applicable
- Retry action works after failure
- Pull-to-refresh works correctly
- Dark mode works if supported

# 7. Network and error handling

- App handles no internet gracefully
- App handles timeout gracefully
- App handles 500 server error gracefully
- App handles malformed JSON safely
- App handles SSL or connection errors properly
- Error message shown to user is understandable
- Retry after failure works
- App does not crash on API failure

# 8. Push notification / FCM testing

## Token handling

- FCM token is generated successfully
- FCM token is sent to Laravel after login
- FCM token is stored in DB correctly
- Token refresh is handled and updated in backend
- Logout clears token if required

## Notification delivery

- Notification sent from Laravel reaches device
- Notification arrives when app is in foreground
- Notification arrives when app is in background
- Notification arrives when app is terminated
- Notification tap opens correct screen
- Data payload is received correctly
- Notification title/body display correctly
- Duplicate notifications are not sent unexpectedly

## Backend FCM API

- Notification API validates required fields
- Invalid device token returns proper error
- Notification API handles missing token correctly
- Notification API handles Firebase failure correctly
- Stored tokens are used correctly for sending

# 9. Data and list screens

For each listing screen:

- List loads successfully
- Pagination works correctly
- Search works correctly
- Filter works correctly
- Sorting works correctly
- Empty list state displays properly
- Pull-to-refresh reloads updated data
- Duplicate items do not appear
- Deleted/updated records reflect correctly in UI

# 10. File/image upload testing

- Image upload works with supported file types
- Invalid file type is rejected
- Oversized file is rejected
- Uploaded image displays correctly
- Upload progress/loading works
- Upload failure shows proper error
- Re-upload/update image works correctly

# 11. Payment/order/cart style flows if applicable

## Cart

- Add item to cart works
- Update quantity works
- Remove item from cart works
- Cart total calculates correctly
- Duplicate item handling works correctly

## Checkout / order

- Order places successfully with valid data
- Invalid checkout data is rejected
- Order summary is correct
- Payment success updates order properly
- Payment failure is handled properly
- Duplicate order is not created on repeated tap
- Order status updates correctly

# 12. Search testing

- Search returns correct results
- Search with no result shows empty state
- Search works with special characters
- Search works with partial keywords
- Search debounce works properly if implemented

# 13. Security testing

- Protected APIs require valid token
- Sensitive data is not exposed in API response
- User cannot access another user’s data by changing ID
- SQL injection-like payloads do not break API
- XSS-like input is safely handled where relevant
- Password/token is not logged in plaintext
- App does not expose secrets in UI/logs

# 14. Performance testing

- App launch time is acceptable
- API response time is acceptable under normal load
- Long lists scroll smoothly
- Images load efficiently
- Memory usage is stable
- Repeated navigation does not cause lag/crash

# 15. Device and platform testing

## Android

- Works on Android 10/11/12/13/14 if in scope
- Notification permission works on Android 13+
- Back button behavior is correct

## iOS

- Works on supported iOS versions
- Push notifications work on real device
- Permission prompt works correctly
- Navigation and gestures behave correctly

# 16. Regression checklist

Run this after every major update:

- Login
- Logout
- OTP verify
- Profile update
- Home screen load
- Main listing screen load
- Create/update/delete important record
- Push notification receive
- Token expiry handling
- Search/filter
- Critical payment/order flow if applicable

# 17. Laravel backend admin/testing checklist

- `.env` values are correct in server
- Queue worker runs correctly if notifications/jobs use queue
- Logs are generated for failures
- Failed jobs are trackable
- Database migrations run successfully
- API rate limits work if configured
- CORS works correctly for app requests
- Storage links/files work correctly
- Firebase credentials file path is valid
- JWT config works in staging/production

# 18. Recommended test case sheet columns

Use these columns in Excel or Google Sheets:

- Test Case ID
- Module
- Test Scenario
- Preconditions
- Steps
- Test Data
- Expected Result
- Actual Result
- Status
- Remarks

Example:

- TC_AUTH_001
- Authentication
- Login with valid mobile and OTP
- User exists and OTP generated
- Enter mobile, enter OTP, tap verify
- Mobile: 9999999999, OTP: 1234
- User logs in and token is returned
- Pending
- Pending
-   -

# 19. High-priority smoke test list

If you want a quick daily test list, use this:

- App launches
- Login works
- OTP works
- Home page loads
- One main API list loads
- One create action works
- One update action works
- Logout works
- Push notification works
- No crash on basic navigation
