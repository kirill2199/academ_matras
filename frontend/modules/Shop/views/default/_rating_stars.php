<?php
/** @var $rating float */
$fullStars = floor($rating);
$hasHalfStar = ($rating - $fullStars) >= 0.5;
$emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
?>

<span>
    <?php for ($i = 0; $i < $fullStars; $i++): ?>
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z" fill="#FFA800"></path>
        </svg>
    <?php endfor; ?>
    
    <?php if ($hasHalfStar): ?>
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z" fill="#FFA800" fill-opacity="0.5"></path>
        </svg>
    <?php endif; ?>
    
    <?php for ($i = 0; $i < $emptyStars; $i++): ?>
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z" fill="#E0E0E0"></path>
        </svg>
    <?php endfor; ?>
</span>