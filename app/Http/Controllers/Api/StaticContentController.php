<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    private array $staticData = [
        'terms_and_conditions' => [
            'title' => 'Terms and Conditions',
            'last_updated' => '2024-01-01',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'Terms and Conditions'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Welcome to CrackTech. By accessing and using our application, you agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our service.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => '1. Acceptance of Terms'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'By downloading, installing, or using the CrackTech mobile application, you accept and agree to be bound by the terms of this agreement. Additionally, when using CrackTech services, you shall be subject to any posted guidelines or rules applicable to such services.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => '2. Description of Service'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'CrackTech provides users with access to a rich collection of resources, including various communications tools, forums, shopping services, personalized content, and branded programming through its network of properties.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => '3. Your Registration Obligations'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'In consideration of your use of the Service, you agree to: (a) provide true, accurate, current, and complete information about yourself as prompted by the Service\'s registration form and (b) maintain and promptly update the registration data to keep it true, accurate, current, and complete.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => '4. Privacy Policy'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Registration data and certain other information about you is subject to our Privacy Policy. You understand that through your use of the Service, you consent to the collection and use of this information, including the transfer of this information to other countries for storage, processing, and use.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => '5. User Conduct'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'You agree not to use the Service to: upload, post, email, transmit, or otherwise make available any content that is unlawful, harmful, threatening, abusive, harassing, tortious, defamatory, vulgar, obscene, libelous, invasive of another\'s privacy, hateful, or racially, ethnically, or otherwise objectionable.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => '6. Payment and Refund Policy'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'All payments made through the app are final. Refunds are processed according to our Refund Policy which allows returns within 7 days of purchase for unused products in original condition.'
                ],
                [
                    'type' => 'list',
                    'style' => 'bullet',
                    'items' => [
                        'Items must be unused and in original packaging',
                        'Original receipt or proof of purchase required',
                        'Refund will be processed within 5-7 business days',
                        'Shipping charges are non-refundable'
                    ]
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => '7. Shipping Policy'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We ship products within 2-3 business days of order confirmation. Delivery timelines vary by location and shipping method selected at checkout.'
                ],
                [
                    'type' => 'list',
                    'style' => 'ordered',
                    'items' => [
                        'Standard Shipping: 5-7 business days',
                        'Express Shipping: 2-3 business days',
                        'Same Day Delivery: Available for select pincodes'
                    ]
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => '8. Contact Information'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'If you have any questions about these Terms and Conditions, please contact us at support@cracktech.com or call our customer support team.'
                ]
            ]
        ],
        'privacy_policy' => [
            'title' => 'Privacy Policy',
            'last_updated' => '2024-01-01',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'Privacy Policy'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'This Privacy Policy describes how CrackTech collects, uses, and shares your personal information when you use our mobile application and services.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Information We Collect'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We collect information you provide directly to us, including your name, email address, phone number, and payment information when you create an account or make a purchase.'
                ],
                [
                    'type' => 'list',
                    'style' => 'bullet',
                    'items' => [
                        'Personal identification information',
                        'Payment and transaction data',
                        'Device and usage data',
                        'Location data (with your consent)'
                    ]
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'How We Use Your Information'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We use the information we collect to provide, maintain, and improve our services, to process your transactions, and to communicate with you about products and services.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Data Security'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.'
                ]
            ]
        ],
        'refund_policy' => [
            'title' => 'Refund Policy',
            'last_updated' => '2024-01-01',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'Refund Policy'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We want you to be completely satisfied with your purchase. This policy outlines our refund guidelines.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Eligibility for Refund'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'To be eligible for a refund, your request must be made within 7 days of purchase and meet the following conditions:'
                ],
                [
                    'type' => 'list',
                    'style' => 'ordered',
                    'items' => [
                        'Product must be unused and in original packaging',
                        'All tags and labels must be attached',
                        'Original receipt or proof of purchase required',
                        'Product must not be damaged due to customer misuse'
                    ]
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Non-Refundable Items'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'The following items cannot be returned or refunded:'
                ],
                [
                    'type' => 'list',
                    'style' => 'bullet',
                    'items' => [
                        'Opened or used software products',
                        'Personal care products',
                        'Gift cards and vouchers',
                        'Special order items'
                    ]
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Refund Process'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Once we receive your returned item and inspect it, we will process your refund within 5-7 business days. The amount will be credited to your original payment method.'
                ]
            ]
        ],
        'shipping_policy' => [
            'title' => 'Shipping Policy',
            'last_updated' => '2024-01-01',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'Shipping Policy'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We strive to deliver your orders quickly and safely. Here\'s everything you need to know about our shipping process.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Shipping Times'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Orders are processed within 2-3 business days. Delivery times vary based on your location and selected shipping method.'
                ],
                [
                    'type' => 'list',
                    'style' => 'ordered',
                    'items' => [
                        'Standard Shipping: 5-7 business days - FREE',
                        'Express Shipping: 2-3 business days - ₹99',
                        'Same Day Delivery: Within 24 hours - ₹199'
                    ]
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Order Tracking'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Once your order ships, you will receive a tracking number via SMS and email to monitor your delivery status.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'International Shipping'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Currently, we only ship within India. International shipping will be available soon.'
                ]
            ]
        ],
        'about_us' => [
            'title' => 'About Us',
            'last_updated' => '2024-01-01',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'About CrackTech'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'CrackTech is a leading provider of technology solutions and services, dedicated to delivering excellence in customer support and product services across India.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Our Mission'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'To provide exceptional service and innovative solutions that enhance the lives of our customers through technology.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Our Vision'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'To be the most trusted and reliable technology service provider in the industry.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Why Choose Us'
                ],
                [
                    'type' => 'list',
                    'style' => 'bullet',
                    'items' => [
                        'Professional and certified technicians',
                        'Transparent pricing',
                        'Warranty on all services',
                        '24/7 customer support',
                        'Trusted by 50,000+ customers'
                    ]
                ]
            ]
        ],
        'contact_us' => [
            'title' => 'Contact Us',
            'last_updated' => '2024-01-01',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'Contact Us'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We\'re here to help! Reach out to us through any of the following channels.'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Customer Support'
                ],
                [
                    'type' => 'list',
                    'style' => 'bullet',
                    'items' => [
                        'Email: support@cracktech.com',
                        'Phone: +91 1800 123 4567 (Mon-Sat, 9AM-6PM)',
                        'WhatsApp: +91 98765 43210'
                    ]
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Headquarters'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'CrackTech Solutions Pvt. Ltd.\n123 Tech Park, Sector 4\nGurgaon, Haryana 122001\nIndia'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Business Inquiries'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'For partnership and business opportunities, email us at business@cracktech.com'
                ]
            ]
        ],
        'faq' => [
            'title' => 'Frequently Asked Questions',
            'last_updated' => '2024-01-01',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'Frequently Asked Questions'
                ],
                [
                    'type' => 'faq_item',
                    'question' => 'How do I track my order?',
                    'answer' => 'You can track your order by logging into your CrackTech app and visiting the "My Orders" section. You will also receive SMS and email updates with your tracking information.'
                ],
                [
                    'type' => 'faq_item',
                    'question' => 'What is your return policy?',
                    'answer' => 'We offer a 7-day return policy for most products. Items must be unused, in original packaging, with all tags attached. Please keep your receipt for proof of purchase.'
                ],
                [
                    'type' => 'faq_item',
                    'question' => 'How can I cancel my order?',
                    'answer' => 'You can cancel your order within 24 hours of placement by visiting "My Orders" in the app or contacting customer support. Orders that have already shipped cannot be cancelled.'
                ],
                [
                    'type' => 'faq_item',
                    'question' => 'What payment methods do you accept?',
                    'answer' => 'We accept all major credit/debit cards, UPI, net banking, wallets (Paytm, PhonePe, Google Pay), and cash on delivery for eligible orders.'
                ],
                [
                    'type' => 'faq_item',
                    'question' => 'Do you offer warranty on products?',
                    'answer' => 'Yes, all electronic products come with manufacturer warranty. Additional warranty options are available at checkout.'
                ],
                [
                    'type' => 'faq_item',
                    'question' => 'How do I book a service request?',
                    'answer' => 'Download the CrackTech app, select "Book Service", choose your service type, and select a convenient time slot. Our technician will visit you at the scheduled time.'
                ],
                [
                    'type' => 'faq_item',
                    'question' => 'What areas do you service?',
                    'answer' => 'We currently provide services across major cities in India. Enter your pincode in the app to check service availability in your area.'
                ]
            ]
        ],
        'app_version' => [
            'title' => 'App Version',
            'last_updated' => '2024-01-01',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'App Information'
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'CrackTech App v1.0.0'
                ],
                [
                    'type' => 'heading',
                    'level' => 2,
                    'text' => 'Version History'
                ],
                [
                    'type' => 'list',
                    'style' => 'ordered',
                    'items' => [
                        'v1.0.0 - Initial release',
                        'Performance improvements',
                        'Bug fixes'
                    ]
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'We continuously update our app with new features and improvements. Please keep your app updated to the latest version for the best experience.'
                ]
            ]
        ]
    ];

    public function getStaticContent(string $key): JsonResponse
    {
        if (isset($this->staticData[$key])) {
            return response()->json([
                'success' => true,
                'data' => $this->staticData[$key],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Static content not found',
        ], 404);
    }

    public function getAllStaticContent(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->staticData,
        ]);
    }

    public function getAvailableKeys(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'keys' => array_keys($this->staticData),
        ]);
    }
}