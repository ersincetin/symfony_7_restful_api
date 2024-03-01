<?php

namespace App\Service\Concretes;

use App\Entity\Record;
use App\Service\Abstracts\IRecordService;
use App\Service\Abstracts\IUserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecordService implements IRecordService
{
    private $data = array();

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Record::class);
    }

    public function find(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($record = $this->repository->find($id))) {
                $this->data = [
                    'id' => $record->getId(),
                    'status' => $record->getStatus(),
                    'who_added' => $record->getUser()->getUsername(),
                    'identification_number' => $record->getIdentificationNumber(),
                    'performance_score' => $record->getPerformanceScore(),
                    'base_score' => $record->getBaseScore(),
                    'negativity_parameter_score' => $record->getNegativityParameterScore(),
                    'structural_system_score' => $record->getStructuralSystemScore(),
                    'performance_score_detail_json' => $record->getPerformanceScoreDetailJson(),
                    'identity_information' => [
                        'country_id' => $record->getIdentityInformation()->getCountryId(),
                        'state_id' => $record->getIdentityInformation()->getStateId(),
                        'city_id' => $record->getIdentityInformation()->getCityId(),
                        'neighborhood' => $record->getIdentityInformation()->getNeighborhood(),
                        'street' => $record->getIdentityInformation()->getStreet(),
                        'exterior_door_number' => $record->getIdentityInformation()->getExteriorDoorNumber(),
                        'building_name' => $record->getIdentityInformation()->getBuildingName(),
                        'layout' => $record->getIdentityInformation()->getLayout(),
                        'block' => $record->getIdentityInformation()->getBlock(),
                        'plot' => $record->getIdentityInformation()->getPlot(),
                        'uavt_building_code' => $record->getIdentityInformation()->getUavtBuildingCode(),
                        'estimated_age_of_the_building' => $record->getIdentityInformation()->getEstimatedAgeOfTheBuilding(),
                        'latitude' => $record->getIdentityInformation()->getLatitude(),
                        'longitude' => $record->getIdentityInformation()->getLongitude(),
                        'building_usage_type' => $record->getIdentityInformation()->getBuildingUsageType(),
                    ],
                    'technical_information' => [
                        'sds' => $record->getTechnicalInformation()->getSds(),
                        'building_type' => $record->getTechnicalInformation()->getBuildingType(),
                        'structural_system_type' => $record->getTechnicalInformation()->getStructuralSystemType(),
                        'number_of_free_floors' => $record->getTechnicalInformation()->getNumberOfFreeFloors(),
                        'number_of_free_floors_input' => $record->getTechnicalInformation()->getNumberOfFreeFloorsInput(),
                        'building_visual_quality' => $record->getTechnicalInformation()->getBuildingVisualQuality(),
                        'soft_floor' => $record->getTechnicalInformation()->getSoftFloor(),
                        'vertical_irregularity' => $record->getTechnicalInformation()->getVerticalIrregularity(),
                        'heavy_bounces' => $record->getTechnicalInformation()->getHeavyBounces(),
                        'irregularity_in_plan' => $record->getTechnicalInformation()->getIrregularityInPlan(),
                        'short_colon_effect' => $record->getTechnicalInformation()->getShortColonEffect(),
                        'building_regulations' => $record->getTechnicalInformation()->getBuildingRegulations(),
                        'floorLevel_in_adjacent_buildings' => $record->getTechnicalInformation()->getFloorLevelInAdjacentBuildings(),
                        'natural_ground_slope' => $record->getTechnicalInformation()->getNaturalGroundSlope(),
                        'bearing_wall_type' => $record->getTechnicalInformation()->getBearingWallType(),
                        'masonry_building_type' => $record->getTechnicalInformation()->getMasonryBuildingType(),
                        'masonry_wall_material_quality' => $record->getTechnicalInformation()->getMasonryWallMaterialQuality(),
                        'masonry_wall_work' => $record->getTechnicalInformation()->getMasonryWallWork(),
                        'current_damage' => $record->getTechnicalInformation()->getCurrentDamage(),
                        'horizontal_beam' => $record->getTechnicalInformation()->getHorizontalBeam(),
                        'ground_floor_plan_width_front_facade' => $record->getTechnicalInformation()->getGroundFloorPlanWidthFrontFacade(),
                        'ground_floor_plan_width_side_facade' => $record->getTechnicalInformation()->getGroundFloorPlanWidthSideFacade(),
                        'amount_of_ground_floor_space_front_facade' => $record->getTechnicalInformation()->getAmountOfGroundFloorSpaceFrontFacade(),
                        'amount_of_ground_floor_space_side_facade' => $record->getTechnicalInformation()->getAmountOfGroundFloorSpaceSideFacade(),
                        'vertical_clearance_irregularity' => $record->getTechnicalInformation()->getVerticalClearanceIrregularity(),
                        'floor_difference_according_to_facade' => $record->getTechnicalInformation()->getFloorDifferenceAccordingToFacade(),
                        'flooring_type' => $record->getTechnicalInformation()->getFlooringType(),
                        'mortar_material' => $record->getTechnicalInformation()->getMortarMaterial(),
                        'wall_to_wall_connections' => $record->getTechnicalInformation()->getWallToWallConnections(),
                        'wall_trim_connections' => $record->getTechnicalInformation()->getWallTrimConnections(),
                        'roof_material' => $record->getTechnicalInformation()->getRoofMaterial(),
                        'ground_type' => $record->getTechnicalInformation()->getGroundType(),
                        'note' => $record->getTechnicalInformation()->getNote(),
                    ]
                ];
                return new JsonResponse([
                    'data' => $this->data,
                    'message' => 'Successful'
                ], 200);
            } else {
                return new JsonResponse([
                    'id' => $id ?? null,
                    'message' => 'Show for not found role'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 404);
        }
    }

    public function findAll()
    {
        try {
            if (count($records = $this->repository->findAll()) > 0)
                foreach ($records as $record) {
                    array_push($this->data, [
                        'id' => $record->getId(),
                        'status' => $record->getStatus(),
                        'who_added' => $record->getUser()->getUsername(),
                        'identification_number' => $record->getIdentificationNumber(),
                        'performance_score' => $record->getPerformanceScore(),
                        'base_score' => $record->getBaseScore(),
                        'negativity_parameter_score' => $record->getNegativityParameterScore(),
                        'structural_system_score' => $record->getStructuralSystemScore(),
                        'performance_score_detail_json' => json_decode($record->getPerformanceScoreDetailJson(), true),
                        'identity_information' => [
                            'country_id' => $record->getIdentityInformation()->getCountryId(),
                            'state_id' => $record->getIdentityInformation()->getStateId(),
                            'city_id' => $record->getIdentityInformation()->getCityId(),
                            'neighborhood' => $record->getIdentityInformation()->getNeighborhood(),
                            'street' => $record->getIdentityInformation()->getStreet(),
                            'exterior_door_number' => $record->getIdentityInformation()->getExteriorDoorNumber(),
                            'building_name' => $record->getIdentityInformation()->getBuildingName(),
                            'layout' => $record->getIdentityInformation()->getLayout(),
                            'block' => $record->getIdentityInformation()->getBlock(),
                            'plot' => $record->getIdentityInformation()->getPlot(),
                            'uavt_building_code' => $record->getIdentityInformation()->getUavtBuildingCode(),
                            'estimated_age_of_the_building' => $record->getIdentityInformation()->getEstimatedAgeOfTheBuilding(),
                            'latitude' => $record->getIdentityInformation()->getLatitude(),
                            'longitude' => $record->getIdentityInformation()->getLongitude(),
                            'building_usage_type' => $record->getIdentityInformation()->getBuildingUsageType(),
                        ],
                        'technical_information' => [
                            'sds' => $record->getTechnicalInformation()->getSds(),
                            'building_type' => $record->getTechnicalInformation()->getBuildingType(),
                            'structural_system_type' => $record->getTechnicalInformation()->getStructuralSystemType(),
                            'number_of_free_floors' => $record->getTechnicalInformation()->getNumberOfFreeFloors(),
                            'number_of_free_floors_input' => $record->getTechnicalInformation()->getNumberOfFreeFloorsInput(),
                            'building_visual_quality' => $record->getTechnicalInformation()->getBuildingVisualQuality(),
                            'soft_floor' => $record->getTechnicalInformation()->getSoftFloor(),
                            'vertical_irregularity' => $record->getTechnicalInformation()->getVerticalIrregularity(),
                            'heavy_bounces' => $record->getTechnicalInformation()->getHeavyBounces(),
                            'irregularity_in_plan' => $record->getTechnicalInformation()->getIrregularityInPlan(),
                            'short_colon_effect' => $record->getTechnicalInformation()->getShortColonEffect(),
                            'building_regulations' => $record->getTechnicalInformation()->getBuildingRegulations(),
                            'floorLevel_in_adjacent_buildings' => $record->getTechnicalInformation()->getFloorLevelInAdjacentBuildings(),
                            'natural_ground_slope' => $record->getTechnicalInformation()->getNaturalGroundSlope(),
                            'bearing_wall_type' => $record->getTechnicalInformation()->getBearingWallType(),
                            'masonry_building_type' => $record->getTechnicalInformation()->getMasonryBuildingType(),
                            'masonry_wall_material_quality' => $record->getTechnicalInformation()->getMasonryWallMaterialQuality(),
                            'masonry_wall_work' => $record->getTechnicalInformation()->getMasonryWallWork(),
                            'current_damage' => $record->getTechnicalInformation()->getCurrentDamage(),
                            'horizontal_beam' => $record->getTechnicalInformation()->getHorizontalBeam(),
                            'ground_floor_plan_width_front_facade' => $record->getTechnicalInformation()->getGroundFloorPlanWidthFrontFacade(),
                            'ground_floor_plan_width_side_facade' => $record->getTechnicalInformation()->getGroundFloorPlanWidthSideFacade(),
                            'amount_of_ground_floor_space_front_facade' => $record->getTechnicalInformation()->getAmountOfGroundFloorSpaceFrontFacade(),
                            'amount_of_ground_floor_space_side_facade' => $record->getTechnicalInformation()->getAmountOfGroundFloorSpaceSideFacade(),
                            'vertical_clearance_irregularity' => $record->getTechnicalInformation()->getVerticalClearanceIrregularity(),
                            'floor_difference_according_to_facade' => $record->getTechnicalInformation()->getFloorDifferenceAccordingToFacade(),
                            'flooring_type' => $record->getTechnicalInformation()->getFlooringType(),
                            'mortar_material' => $record->getTechnicalInformation()->getMortarMaterial(),
                            'wall_to_wall_connections' => $record->getTechnicalInformation()->getWallToWallConnections(),
                            'wall_trim_connections' => $record->getTechnicalInformation()->getWallTrimConnections(),
                            'roof_material' => $record->getTechnicalInformation()->getRoofMaterial(),
                            'ground_type' => $record->getTechnicalInformation()->getGroundType(),
                            'note' => $record->getTechnicalInformation()->getNote(),
                        ]
                    ]);
                }
            return new JsonResponse([
                'data' => $this->data,
                'message' => 'Successful'
            ], 200);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 404);
        }
    }

    public function create(string $content = null)
    {
        try {
            if (strlen($content) > 0) {
                $parameters = json_decode($content, true);
                $record = new Record();
                $record->setStatus($parameters['status']);
                $record->setUserId($parameters['who_added']);
                $record->setIdentificationNumber($parameters['identification_number']);
                $record->setPerformanceScore($parameters['performance_score']);
                $record->setBaseScore($parameters['base_score']);
                $record->setNegativityParameterScore($parameters['negativity_parameter_score']);
                $record->setStructuralSystemScore($parameters['structural_system_score']);
                $record->setCreatedAt(new \DateTime());

                $this->entityManager->persist($record);
                $this->entityManager->flush();
                return new JsonResponse([
                    'data' => $record->getIdentificationNumber() . ' created.',
                    'message' => 'Successfully'
                ], 200);
            } else {
                return new JsonResponse([
                    'message' => 'Please check your request body'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function update(string $content = null, int $id = null)
    {
        try {
            $record = new Record();
            return new JsonResponse([
                'data' => $record->getIdentificationNumber() . ' updated.',
                'message' => 'Successfully'
            ], 200);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function delete(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($user = $this->repository->find($id))) {
                $user->setDeletedAt(new \DateTime());
                $this->entityManager->flush();
                return new JsonResponse([
                    'data' => $user->getIdentificationNumber() . ' deleted.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return new JsonResponse([
                    'id' => $id,
                    'message' => 'Delete for not found record'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], 404);
        }
    }
    public function setStatus(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($record = $this->repository->find($id))) {
                $record->setStatus($record->getStatus() ? false : true);
                $this->entityManager->flush();
                return new JsonResponse([
                    'data' => $record->getIdentificationNumber() . ' updated set status.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return new JsonResponse([
                    'id' => $id ?? null,
                    'message' => 'Not found record'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 404);
        }
    }

}