<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    private array $staticData = [
        't_n_c_amc_remote' => [
            'title' => 'Terms and Conditions AMC Remote Support Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Annual Maintenance Contract Remote Support Services. By availing any of our services, the 
                        client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Remote support services are provided only for devices covered under a valid AMC agreement.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Clients must provide accurate device identification details, including MAC ID where applicable, for authentication.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Remote support is dependent on active internet connectivity at the client’s premises.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Support will be provided during standard business hours unless otherwise agreed in writing.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Issues requiring physical intervention will be treated as onsite service requests.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Hardware-related faults cannot be resolved remotely and may require onsite inspection.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. The client is responsible for maintaining data backups prior to remote access sessions.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '8. Unauthorized software installations, malware infections, or system alterations may fall outside AMC coverage. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '9. Remote access will be used strictly for maintenance, diagnostics, and troubleshooting purposes.'
                ],
                
            ]
        ],
        't_n_c_amc_Onsite' => [
            'title' => 'Terms and Conditions AMC Onsite Support Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Annual Maintenance Contract Onsite Services. By availing any of our services, the 
                        client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Onsite services will be delivered as per the scope defined in the AMC agreement.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Preventive maintenance visits will be scheduled mutually between both parties.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Response time for service calls will be as agreed in the AMC contract.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Spare parts and consumables are chargeable unless explicitly included.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Damage caused by power fluctuations, liquid spills, mishandling, or external factors is excluded.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. The client must provide proper working conditions including power supply and access to equipment.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. Additional visits beyond the agreed scope may be billed separately.'
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