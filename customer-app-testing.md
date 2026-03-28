# Customer App Testing 


1. Login Page:

i. Login with Phone Number - using wrong phone number - showing error user not found          - passed
ii. Login with Phone Number - using correct phone number - user logged in and redirect to dashboard  - passed
iii. login with email and password - using wrong email and password -     error not showing properly  - api pending
iv. login with google - if customer already exists duplicate entry error showing - not properly error shown - 
v. 


2. Signup form: 

i. using 9 digit phone number - showing error properly  - passed
ii. using 11 digit phone number - showing error properly  - passed 
iii. using wrong email address - showing error properly  - passed
iv. using correct details - created customer successfully - passed 
v. add password field for customer - need to add password field  - pending 


3. Forgot Password: not implemented


4. Dashboard Page: 

i. quick service list - not displaying properly 
ii. quick add - displayed categories properly - passed
iii. redirection on other pages - correctly redirected - passed 
iv. notifications - not implemented - pending 


5. Service Enquiries Page: 

i. enquiries categories - displayed correctly - passed 

6. Products Page: 
i. search filter : apply properly  - passed
ii. category filter : apply properly  - passed
iii. both filters : apply properly  - passed
iv. products list: displayed properly - passed 
v. product detail page: displayed properly - passed 
vi. payment page: 
    - display selected product with quantity and price summary - passed 
    - payment options like razorpay, cash on delivery - passed
    - apply coupon code option displaying - passed
    - "remove add new upi id" option - pending 
    - check address available or not before buying product - passed 
    - if back from payment page still order is generating - order is non generatable - pending 

7. Profile Page: 
    Personal Info Page: 
        - personal details - email updation need to be disabled 
    Address: 
        - changing primary address - no option available 
    Documents: 
        - Uploading documents 
        - updating documents
    Company: 
        - adding company details 
        - updating company details 

8. My Product Orders: 
    - List of orders 
    - If order is confirmed then customer can cancel order 
    - If order is delivered and product is return/replaceble customer can use those options 
    - customer will get reward after order is delivered 
    - customer will download invoice after order is delivered 
    - after reward scratched reward will be added to my rewards section 

9. My Rewards: 
    - List of rewards 
    - reward code will be copied to clipboard 



# Website

1. login: 
    - otp is not sending when customer login with phone number 
2. password reset link not getting 


