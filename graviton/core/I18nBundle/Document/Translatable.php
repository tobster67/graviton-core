<?php
/**
 * Graviton\I18nBundle\Document\Translatable
 */

namespace Graviton\I18nBundle\Document;

/**
 * Graviton\I18nBundle\Document\Translatable
 *
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 */
class Translatable
{
    /**
     * @var string $id
     */
    protected $id;

    /**
     * @var string $domain
     */
    protected $domain;

    /**
     * @var string $locale
     */
    protected $locale;

    /**
     * @var string $original
     */
    protected $original;

    /**
     * @var string $translated
     */
    protected $translated;

    /**
     * @var boolean $isLocalized
     */
    protected $isLocalized;

    /**
     * set id
     *
     * @param string $id id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set domain
     *
     * @param string $domain domain
     *
     * @return void
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * set locale
     *
     * @param string $locale locale
     *
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * get original
     *
     * @param string $original original string
     *
     * @return void
     */
    public function setOriginal($original)
    {
        $this->original = $original;
    }

    /**
     * get original
     *
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * set translated
     *
     * @param string $translated translated string
     *
     * @return void
     */
    public function setTranslated($translated)
    {
        $this->translated = $translated;
    }

    /**
     * get translated string
     *
     * @return string
     */
    public function getTranslated()
    {
        return $this->translated;
    }

    /**
     * set isLocalized
     *
     * @param boolean $isLocalized true/false
     *
     * @return void
     */
    public function setIsLocalized($isLocalized)
    {
        $this->isLocalized = $isLocalized;
    }

    /**
     * is this document localized
     *
     * @return boolean
     */
    public function isLocalized()
    {
        return $this->isLocalized;
    }

    /**
     * @var string $language url
     */
    protected $language;

    /**
     * Set language
     *
     * @param string $language url
     * @return self
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Get language
     *
     * @return string $language
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
