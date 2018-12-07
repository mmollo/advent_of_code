<?php
$input = [];
while ($line = rtrim(fgets(STDIN))) {
    $input[] = $line;
}

function parse($str) {
    preg_match('/Step ([A-Z]) must be finished before step ([A-Z]) can begin/', $str, $matches);
    return [$matches[1], $matches[2]];
}

class JobList
{
    public $jobs = [];

    public function add($name, $parent)
    {
        $this->jobs[$name] = $this->jobs[$name] ?? [];
        $this->jobs[$parent] = $this->jobs[$parent] ?? [];
        
        $this->jobs[$name][$parent] = true;
    }

    /**
     * Find the next available job.
     * An available job is a job without parents (previous jobs)
     */
    public function next()
    {
        foreach($this->jobs as $job => $parents) {
            if(true === $parents || 0 !== count($parents)) continue;

            // Marks the job as beeing processed
            $this->jobs[$job] = true;
            return $job;
            
        }

        return false;
    }

    public function remove($name)
    {
        foreach($this->jobs as &$job) unset($job[$name]);
        unset($this->jobs[$name]);
    }
}

class WorkPool
{
    public $nb_working = 0;
    public $workers;
    public $base_time;


    public function __construct($workers = 1, $base_time = 60)
    {
        $this->workers = array_fill(0, $workers, null);
        $this->base_time = $base_time;
    }

    private function get_time($job)
    {
        return ord($job) - 64 + $this->base_time;
    }

    public function add($job)
    {
        if(!$job) return false;

        foreach($this->workers as &$worker) {
            if(is_null($worker)) {
                $worker = [$job, $this->get_time($job)];
                return ++$this->nb_working !== count($this->workers);
            }
        }

        return false;
    }

    /**
     * Finds the next(s) finishing job(s)
     * Simulates the processing time
     */
    public function next()
    {
        // Find the time of the job with the least time remaining
        $min = +INF;
        foreach($this->workers as $worker) {
            if(is_null($worker)) continue;
            if($worker[1] < $min) {
                $min = $worker[1];
            }
        }

        /*
        * Removes the time from all jobs and select finished jobs
        */
        $done = [];
        foreach($this->workers as &$worker) {
            if(is_null($worker)) continue;
            $worker[1] -= $min;
            if(0 === $worker[1]) {
                $done[] = $worker[0];
                $worker = null;
                $this->nb_working--;
            }
        }

        return [$min, $done];
    }
}

$jobList = new JobList();
foreach($input as $str) {
    list($pname, $cname) = parse($str);
    $jobList->add($cname, $pname);
}

$pool = new WorkPool(5);

$total_time = 0;

// Those are ugly loops
while(count($jobList->jobs)) {
    $job = $jobList->next();
    while($pool->add($job)) {
        $job = $jobList->next();
    }
    list($time, $done) = $pool->next();
    $total_time += $time;
    array_walk($done, [$jobList, 'remove']);
}

echo $total_time; // 1226