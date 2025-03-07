<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */

/**
 * Task to create a javadoc-like documentation based on current database and
 * changelog.
 *
 * @author  Stephan Hochdoerfer <S.Hochdoerfer@bitExpert.de>
 * @since   2.4.10
 * @package phing.tasks.ext.liquibase
 */
class LiquibaseDbDocTask extends AbstractLiquibaseTask
{
    protected $outputDir;

    /**
     * Sets the output directory where the documentation gets generated to.
     *
     * @param string the output directory
     */
    public function setOutputDir($outputDir)
    {
        $this->outputDir = $outputDir;
    }

    /**
     * @see AbstractTask::checkParams()
     */
    protected function checkParams()
    {
        parent::checkParams();

        if ((null === $this->outputDir) or !is_dir($this->outputDir)) {
            if (!mkdir($this->outputDir, 0777, true)) {
                throw new BuildException(
                    sprintf(
                        'The directory "%s" does not exist and could not be created!',
                        $this->outputDir
                    )
                );
            }
        }

        if (!is_writable($this->outputDir)) {
            throw new BuildException(
                sprintf(
                    'The directory "%s" is not writable!',
                    $this->outputDir
                )
            );
        }
    }

    /**
     * @see Task::main()
     */
    public function main()
    {
        $this->checkParams();
        $this->execute('dbdoc', escapeshellarg($this->outputDir));
    }
}
