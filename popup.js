const openBtns = document.getElementsByClassName('openPopupBtn');
const closeBtns = document.getElementsByClassName('closePopupBtn');
const popups = document.getElementsByClassName('popupWrapper');


for (let i = 0; i < openBtns.length; i++) {
    openBtns[i].addEventListener('click', () => {
      popups[i].style.display = 'flex';
    });
  }
  
for (let i = 0; i < closeBtns.length; i++) {
    closeBtns[i].addEventListener('click', () => {
      popups[i].style.display = 'none';
    });
  }
document.addEventListener('DOMContentLoaded', function() {
  const winTypeSelect = document.getElementById('winType');
  
    const singleLoserContainer    = document.getElementById('singleLoserContainer');
    const multipleLosersContainer = document.getElementById('multipleLosersContainer');
  
    // Listen for changes to the Win Type dropdown
    if (winTypeSelect) {
      winTypeSelect.addEventListener('change', function() {
        const value = this.value;
  
        if (value === 'discard') {
          // Show single-loser, hide multiple
          singleLoserContainer.style.display    = 'block';
          multipleLosersContainer.style.display = 'none';
        } 
        else if (value === 'selfdraw') {
          // Show multiple-loser, hide single
          singleLoserContainer.style.display    = 'none';
          multipleLosersContainer.style.display = 'block';
        }
        else {
          // If user reselects "Choose Win Type" or something else
          singleLoserContainer.style.display    = 'none';
          multipleLosersContainer.style.display = 'none';
        }
      });
    }
  
    // Prevent selecting duplicate losers in multiple-loser scenario
    // Query all .multiLoserSelect dropdowns
    const multiLoserSelects = document.querySelectorAll('.multiLoserSelect');
  
    multiLoserSelects.forEach(selectEl => {
      selectEl.addEventListener('change', function() {
        checkDuplicateLosers(multiLoserSelects);
      });
    });
  });
  
  /**
   * If the user picks the same name in multiple-loser dropdowns,
   * we can show an alert or automatically revert the selection.
   */
  function checkDuplicateLosers(selects) {
    // gather selected values
    const selectedVals = [];
    
    selects.forEach(sel => {
      if (sel.value) {
        selectedVals.push(sel.value);
      }
    });
  
    // check for duplicates
    const duplicates = findDuplicates(selectedVals); 
    if (duplicates.length > 0) {
      alert("You have chosen the same loser more than once. Please select different players.");
    }
  }
  
  // Helper function to find duplicates in an array
  function findDuplicates(arr) {
    const seen = {};
    const dups = [];
    for (let val of arr) {
      if (val in seen) {
        dups.push(val);
      } else {
        seen[val] = true;
      }
    }
    return dups;
  }