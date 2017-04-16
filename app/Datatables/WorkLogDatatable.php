<?php
namespace App\Datatables;

use App\Models\WorkLog;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkLogRepository;
use App\Traits\Instantiable;
use App\Utils\DateUtils;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\DatatableContract;
use ModelShaper\Datatable\Traits\FilterTrait;
use ModelShaper\Datatable\Traits\SortTrait;

class WorkLogDatatable implements DatatableContract
{
    use FilterTrait, SortTrait, Instantiable;

    /** @var WorkLogRepository */
    protected $workLogRepository;

    /** @var ProjectRepository */
    protected $projectRepository;

    /** @var UserRepository */
    protected $userRepository;

    public function __construct(
        WorkLogRepository $workLogRepository,
        ProjectRepository $projectRepository,
        UserRepository $userRepository
    ) {
        $this->workLogRepository = $workLogRepository;
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
    }

    public function render() : Collection
    {
        return WorkLog::all()
            ->map(function (WorkLog $workLog) {
                return [
                    'id'             => [
                        'display' => $this->workLogRepository->getLink($workLog, '#' . $workLog->id),
                        'raw'     => $workLog->id,
                    ],
                    'project'        => $this->projectRepository->getLink($workLog->project),
                    'user'           => $this->userRepository->getLink($workLog->user),
                    'date'           => [
                        'display' => $workLog->date->toDateString(),
                        'sort'    => $workLog->date->timestamp,
                    ],
                    'time_fieldwork' => [
                        'display' => DateUtils::formatWorkLogTime($workLog->time_fieldwork),
                        'sort'    => $workLog->time_fieldwork,
                    ],
                    'time_office'    => [
                        'display' => DateUtils::formatWorkLogTime($workLog->time_office),
                        'sort'    => $workLog->time_office,
                    ],
                ];
            });
    }
}