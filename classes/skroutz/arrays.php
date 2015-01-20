<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 5/10/2014
 * Time: 9:59 μμ
 */

namespace skroutz {

	if ( ! defined( 'WPINC' ) )
		exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );

	class arrays extends \xd_v141226_dev\arrays {
		/**
		 *
		 * @param $array1
		 * @param $array2
		 * @param bool $___recursion
		 *
		 * @return array
		 * @throws \xd_v141226_dev\exception
		 *
		 * @kudos http://forums.devshed.com/php-development/560363-array_diff_assoc-multidimensional-array-post2130226.html#post2130226
		 */
		public function array_dif_assoc_deep( $array1, $array2, $___recursion = false ) {
			if ( ! $___recursion ) {
				$this->check_arg_types( 'array', 'array', 'boolean', func_get_args() );
			}

			$ret = array();

			foreach ( $array1 as $k => $v ) {
				if ( ! isset( $array2[ $k ] ) ) {
					$ret[ $k ] = $v;
				} else if ( is_array( $v ) && is_array( $array2[ $k ] ) ) {
					$temp = $this->array_dif_assoc_deep( $v, $array2[ $k ], true );
					if ( empty( $temp ) ) {
						$ret = null;
					} else {
						$ret[ $k ] = $temp;
					}
				} else if ( (string) $v != (string) $array2[ $k ] ) {
					$ret[ $k ] = $v;
				}
			}

			return $ret;

		}
	}
}