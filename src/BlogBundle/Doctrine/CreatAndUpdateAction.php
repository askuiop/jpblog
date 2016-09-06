<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-8-4
 * Time: 下午1:17
 */

namespace BlogBundle\Doctrine;


trait CreatAndUpdateAction
{
	/**
	 * @ORM\PrePersist()
	 */
	public function prePersist()
	{
		if (empty($this->createdAt)) {
			$this->setCreatedAt(new \DateTime());
		}
		if (empty($this->updatedAt)) {
			$this->setUpdatedAt(new \DateTime());
		}
	}

	/**
	 * @ORM\PreUpdate()
	 */
	public function preUpdate()
	{
		$this->setUpdatedAt(new \DateTime());
	}
}