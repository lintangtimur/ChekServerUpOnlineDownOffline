<?php
namespace Stelserve;

/**
 * Server Method Initialize
 */
interface IServerMethod
{
    /**
     * Add server
     * @param string $config json config file
     */
  public function addServer($config);
  /**
   * Get Server
   * @return string|array
   */
    public function getServer();

    /**
     * Get Port
     * @return string|array
     */
    public function getPort();
}
