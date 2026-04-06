<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    private array $staticData = [
        // t_n_c_amc_remote,
        // t_n_c_amc_Onsite,
        // t_n_c_ecommerce_order,
        // t_n_c_quick,
        // t_n_c_installation,
        // t_n_c_repair,

        't_n_c_amc_remote' => [
            'title' => 'Terms and Conditions AMC Remote Support Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Annual Maintenance Contract Remote Support Services. By availing any of our services, the client agrees to the terms outlined below. '
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
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
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
                    'text' => 'These Terms and Conditions govern the provision of Annual Maintenance Contract Onsite Services. By availing any of our services, the client agrees to the terms outlined below. '
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
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],            
            ]
        ],
        't_n_c_amc_ecommerce_order' => [
            'title' => 'Terms and Conditions E-Commerce Orders',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of E-Commerce Orders. By availing any of our services, the client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. All orders are subject to product availability.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Product images displayed online are for reference purposes only.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Dispatch timelines are indicative and may vary based on logistics providers.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Returns are accepted only for damaged or defective items reported within 48 hours of delivery.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. An unboxing video may be required for damage claims.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Shipping charges are non-refundable unless the product is defective.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. Cancellation requests are accepted only before dispatch.'
                ],              
                [
                    'type' => 'paragraph',
                    'text' => '8. Warranty, where applicable, will be governed by manufacturer terms.'
                ],    
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],          
            ]
        ],
        't_n_c_amc_quick' => [
            'title' => 'Terms and Conditions Quick Commerce Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Quick Commerce Services. By availing any of our services, the client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Delivery timelines are estimates and not guaranteed.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Service availability depends on delivery location coverage.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Orders once processed may not be modified or cancelled.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Partial deliveries may occur based on stock availability.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Delays caused by traffic, weather, or logistics partners are beyond control.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Payment must be completed prior to dispatch unless otherwise agreed.'
                ],  
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],           
            ]
        ],
        't_n_c_amc_installation' => [
            'title' => 'Terms and Conditions Installation Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Installation Services. By availing any of our services, the 
                        client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Installation will be scheduled based on technician availability.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. The client must ensure site readiness prior to technician visit.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Electrical points, wiring, and infrastructure must be arranged by the client. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. Standard installation is included; additional work is chargeable.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Revisit due to incomplete site readiness may attract additional charges.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Demonstration will be provided at the time of installation.'
                ],  
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],           
            ]
        ],
        't_n_c_repair' => [
            'title' => 'Terms and Conditions Repair Services',
            'last_updated' => '2026-04-06',
            'content' => [
                [
                    'type' => 'heading',
                    'level' => 1,
                    'text' => 'These Terms and Conditions govern the provision of Repair Services. By availing any of our services, the 
                        client agrees to the terms outlined below. '
                ],
                [
                    'type' => 'paragraph',
                    'text' => '1. Devices will be inspected prior to confirming repair feasibility.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '2. Repair timelines depend on fault diagnosis and spare availability.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '3. Clients must back up all data before submitting equipment for repair.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '4. The company is not responsible for data loss during repair.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '5. Repair warranty, if provided, is limited to replaced or repaired components only.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '6. Additional charges may apply for physical or liquid damage.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '7. Devices not collected within 30 days may incur storage charges.'
                ],               
                [
                    'type' => 'paragraph',
                    'text' => '8. Advance payment may be required for special-order spare parts.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* All services are subject to applicable taxes.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Service scope is limited to items listed in the agreement or invoice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* The company reserves the right to modify terms without prior notice.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* Disputes, if any, shall be subject to jurisdiction of the company’s registered office location.'
                ],
                [
                    'type' => 'paragraph',
                    'text' => '* By availing our services, the client acknowledges and agrees to the above Terms and Conditions.'
                ],             
            ]
        ],

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