<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/4/2016
 * Time: 11:46 AM
 */

namespace App\prescription\services;

use App\prescription\utilities\Exception\HelperException;
use App\prescription\utilities\ErrorEnum\ErrorEnum;
use App\prescription\repositories\repointerface\HelperInterface;
use Exception;
use Illuminate\Database\QueryException;

class HelperService
{
    protected $helperRepo;

    public function __construct(HelperInterface $helperRepo) {
        $this->helperRepo = $helperRepo;
    }

    /* Get all the cities
     * @params none
     * @throws HelperException
     * @return array | null
     * @author Baskar
     */

    public function getCities()
    {
        $cities = null;

        try
        {
            $cities = $this->helperRepo->getCities();
        }
        catch(HelperException $cityExc)
        {
            throw $cityExc;
        }
        catch (Exception $ex) {
            throw new HelperException(null, ErrorEnum::CITIES_LIST_ERROR, $ex);
        }

        return $cities;
    }

    /* Generate Id
     * @params $hospitalId, $idType
     * @throws HelperException
     * @return array | null
     * @author Baskaran Subbaraman
     */

    public function generatedId($hospitalId, $idType)
    {
        $generatedId = null;

        try
        {
            $generatedId = $this->helperRepo->generatedId($hospitalId, $idType);
        }
        catch(QueryException $queryEx)
        {

        }
        catch(HelperException $cityExc)
        {
            throw $cityExc;
        }
        catch (Exception $ex)
        {
            throw new HelperException(null, ErrorEnum::ID_GENERATION_ERROR, $ex);
        }

        return $generatedId;
    }
}