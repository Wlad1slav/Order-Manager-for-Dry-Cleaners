<?php

class Rights {
    private int $id; // Ідентифікатор рівня прав
    private string $slug; // Найменування рівня прав
    private array $perms; // Словник усіх прав користувача

    private Utils $utils;

    /**
     * @param int $id
     * @param string $slug
     * @param array $perms
     */
    public function __construct(int $id, string $slug, array $perms) {
        $this->utils = new Utils(); // додаткові утіліти

        $this->id = $id;
        $this->validateSlug($slug); // Перевіряє, чи відповідає слаг нормам
        $this->slug = $slug;
        $this->perms = $perms;
    }

    public function getId(): int {
        // Повертає Ідентифікатор рівня прав
        return $this->id;
    }

    public function getSlug(): string {
        // Повертає слаг замовлення
        return $this->slug;
    }
    public function setSlug(string $slug): void {
        // Встановлює слаг
        $this->slug = $slug;
    }
    private function validateSlug(string $slug): void {
        // Перевіряє, чи складається slug тільки з латинських літер, і чи містить заборонені символи
        $this->utils->validateName($slug, "validateUsername(string $slug)"); // Utils. Викликає помилку, якщо довжина строки = 0
        if (!preg_match('/^[a-zA-Z]+$/', $slug))
            throw new InvalidArgumentException('validateSlug(string $slug): Очікується, що slug буде містити тільки латинські літери');
    }

    public function getPerms(): array {
        // Повертає словник прав
        return $this->perms;
    }

    public function setPerms(array $perms): void {
        // Встановлює словник прав
        $this->perms = $perms;
    }


}