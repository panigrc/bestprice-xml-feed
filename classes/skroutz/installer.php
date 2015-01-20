<?php

/**
 * User: vagenas
 * Date: 9/11/14
 * Time: 11:33 PM
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @copyright 9/11/14 XDaRk.eu <xdark.eu@gmail.com>
 * @link http://xdark.eu
 */

namespace skroutz;

if (!defined('WPINC')) {
    die;
}

/**
 * 
 * @package skroutz
 * @author pan.vagenas <pan.vagenas@gmail.com>
 */
class installer extends \xd_v141226_dev\installer {

    /**
     * Any additional activation routines.
     *
     * @extenders This should be overwritten by class extenders (when/if needed).
     *
     * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
     */
    public function activations() {
        return true; // Indicate success.
    }

    /**
     * Any additional deactivation routines.
     *
     * @extenders This should be overwritten by class extenders (when/if needed).
     *
     * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
     */
    public function deactivations() {
        return TRUE; // Indicate success.
    }

    /**
     * Any additional uninstall routines.
     *
     * @extenders This should be overwritten by class extenders (when/if needed).
     *
     * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
     */
    public function uninstallations() {
        return TRUE; // Indicate success.
    }

}
