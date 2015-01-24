<?php


class PHP_CodeSniffer_Reports_Teamcity implements \PHP_CodeSniffer_Report
{

    function __construct()
    {
        $this->report = new TeamCityReportDTO;
    }

    /**
     * Generate a partial report for a single processed file.
     *
     * Function should return TRUE if it printed or stored data about the file
     * and FALSE if it ignored the file. Returning TRUE indicates that the file and
     * its data should be counted in the grand totals.
     *
     * @param array $report Prepared report data.
     * @param PHP_CodeSniffer_File $phpcsFile The file being reported on.
     * @param boolean $showSources Show sources?
     * @param int $width Maximum allowed line width.
     *
     * @return boolean
     */
    public function generateFileReport(
        $report,
        PHP_CodeSniffer_File $phpcsFile,
        $showSources = false,
        $width = 80
    ) {

        $this->report->totalWarnings += $phpcsFile->getWarningCount();
        $this->report->totalErrors += $phpcsFile->getErrorCount();
        $this->report->totalFiles += 1;
    }

    /**
     * Generate the actual report.
     *
     * @param string $cachedData Any partial report data that was returned from
     *                               generateFileReport during the run.
     * @param int $totalFiles Total number of files processed during the run.
     * @param int $totalErrors Total number of errors found during the run.
     * @param int $totalWarnings Total number of warnings found during the run.
     * @param int $totalFixable Total number of problems that can be fixed.
     * @param boolean $showSources Show sources?
     * @param int $width Maximum allowed line width.
     * @param boolean $toScreen Is the report being printed to screen?
     *
     * @return void
     */
    public function generate(
        $cachedData,
        $totalFiles,
        $totalErrors,
        $totalWarnings,
        $totalFixable,
        $showSources = false,
        $width = 80,
        $toScreen = true
    ) {

            echo $this->teamcityStatMessage('PHPCS Total files', $this->report->totalFiles);
            echo $this->teamcityStatMessage('PHPCS Warnings', $this->report->totalWarnings);
            echo $this->teamcityStatMessage('PHPCS Errors', $this->report->totalErrors);

    }

    protected function teamcityStatMessage($key, $value)
    {
        return sprintf('##teamcity[buildStatisticValue key=\'%s\' value=\'%s\']' . PHP_EOL, $key, $value);
    }

    protected function teamcityReportMessage($type, $path)
    {
        return sprintf('##teamcity[importData type=\'%s\' path=\'%s\']' . PHP_EOL, $type, $path);
    }
}